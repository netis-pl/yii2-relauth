<?php
/**
 * @link http://netis.pl/
 * @copyright Copyright (c) 2015 Netis Sp. z o. o.
 */

namespace netis\rbac;

trait AuthManagerTrait
{
    /**
     * @var array a list of auth items between the one checked and the one assigned to the user,
     * after a successful checkAccess() call.
     */
    private $currentPath = [];
    /**
     * @var array lists of auth items between the one checked and the one assigned to the user.
     */
    private $paths = [];

    /**
     * Returns a list of auth items between the one checked and the one assigned to the user.
     * @param string|integer $userId the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param string $permissionName the name of the permission to be checked against
     * @param array $params name-value pairs that will be passed to the rules associated
     * with the roles and permissions assigned to the user.
     * @param boolean $allowCaching whether to allow caching the accessed path.
     * When this parameter is true (default), if the access check of an operation was performed
     * before, traversed path will be directly returned when calling this method to check the same
     * operation. If this parameter is false, this method will always call
     * [[\yii\rbac\ManagerInterface::checkAccess()]] to obtain the up-to-date traversed path. Note that this
     * caching is effective only within the same request and only works when `$params = []`.
     * @return array
     */
    public function getPath($userId, $permissionName, $params = [], $allowCaching = true)
    {
        if ($allowCaching && empty($params) && isset($this->paths[$userId][$permissionName])) {
            return $this->paths[$userId][$permissionName];
        }
        $this->checkAccess($userId, $permissionName, $params);
        if ($allowCaching && empty($params)) {
            $this->paths[$userId][$permissionName] = $this->currentPath;
        }
        return $this->currentPath;
    }

    /**
     * @inheritdoc
     */
    public function checkAccess($userId, $permissionName, $params = [])
    {
        $this->currentPath = [];
        $result = parent::checkAccess($userId, $permissionName, $params);
        if (empty($params)) {
            $this->paths[$userId][$permissionName] = $this->currentPath;
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function checkAccessFromCache($user, $itemName, $params, $assignments)
    {
        if (parent::checkAccessFromCache($user, $itemName, $params, $assignments)) {
            $this->currentPath[] = $itemName;
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function checkAccessRecursive($user, $itemName, $params, $assignments)
    {
        if (parent::checkAccessRecursive($user, $itemName, $params, $assignments)) {
            $this->currentPath[] = $itemName;
            return true;
        }
        return false;
    }
}
