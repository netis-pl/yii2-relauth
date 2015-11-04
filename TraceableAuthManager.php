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
     * @return array
     */
    public function getPath($userId, $permissionName, $params = []);
}

