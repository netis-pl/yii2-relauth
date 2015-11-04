<?php
/**
 * @link http://netis.pl/
 * @copyright Copyright (c) 2015 Netis Sp. z o. o.
 */

namespace netis\rbac;

interface TraceableAuthManager
{
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
    public function getPath($userId, $permissionName, $params = [], $allowCaching = true);
}

