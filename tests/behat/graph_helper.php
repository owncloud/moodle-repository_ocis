<?php
// This file is part of the ocis repository for Moodle - http://moodle.org/
//
// The ocis repository for Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// The ocis repository for Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with the ocis repository for Moodle.  If not, see <http://www.gnu.org/licenses/>.
//
// ownCloud Infinite Scale for moodle Repository is built with the contributions of:
// - Staatsinstitut für Schulqualität und Bildungsforschung
// - JankariTech
// - ownCloud - a Kiteworks company.

/**
 * Steps definitions related to repository_ocis.
 *
 * @package    repository_ocis
 * @copyright  2017 Project seminar (Learnweb, University of Münster)
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace behat;

use Exception;
use Sabre\DAV\Client;

/**
 * helper class for Ocis API request.
 */
class graph_helper {
    /**
     * id of viewer role permission
     */
    private const VIEWER_ROLE_PERMISSION_ID = 'b1e2218d-eef8-4d4c-b82d-0f1a1b48f3b5';
    /**
     * Alternative password for a user
     */
    private const ALTERNATE_USER_PASSWORD = '1234';

    /**
     * shares space id
     */
    private const SHARES_SPACE_ID = 'a0ca6a90-a365-4782-871e-d44447bbc668$a0ca6a90-a365-4782-871e-d44447bbc668';

    /***
     * array for storing response from share
     * @var string $lastcreatedshareid
     */
    private string $lastcreatedshareid;

    /**
     * Get a new SabreDAV client
     * @param string $user
     * @return Client
     */
    public function get_client(string $user): Client {
        $username = $this->get_actual_username($user);
        $password = $this->get_password_for_user($user);
        $settings = [
            'baseUri' => getenv('MOODLE_OCIS_URL'),
            'userName' => $username,
            'password' => $password,
        ];
        return new Client($settings);
    }

    /**
     * Get the SabreDAV client for the admin user
     * @return Client
     */
    public function get_admin_client(): Client {
        $settings = [
            'baseUri' => getenv('MOODLE_OCIS_URL'),
            'userName' => getenv('OCIS_ADMIN_USERNAME') ? getenv('OCIS_ADMIN_USERNAME') : 'admin',
            'password' => getenv('OCIS_ADMIN_PASSWORD') ? getenv('OCIS_ADMIN_PASSWORD') : 'admin',
        ];
        return new Client($settings);
    }

    /**
     * Returns actual name of a oCIS user
     * @param string $username
     * @return string
     */
    public function get_actual_username(string $username): string {
        if (strtolower($username) === 'admin') {
            return getenv('OCIS_ADMIN_USERNAME') ? getenv('OCIS_ADMIN_USERNAME') : "admin";
        } else {
            return $username;
        }
    }

    /**
     * Returns password of a user
     * @param string $username
     * @return string
     */
    public function get_password_for_user(string $username): string {
        if (strtolower($username) === 'admin') {
            return getenv('OCIS_ADMIN_PASSWORD') ? getenv('OCIS_ADMIN_PASSWORD') : "admin";
        } else {
            return self::ALTERNATE_USER_PASSWORD;
        }
    }

    /**
     * Create a file in personal space
     * @param string $user
     * @param string $file
     * @param string $body
     *
     * @return void
     * @throws Exception
     */
    public function create_file_in_personal_space(string $user, string $file, string $body): void {
        $client = $this->get_client($user);
        $response = $client->request('PUT', "/dav/files/$user/$file", $body);
        if (!in_array($response['statusCode'], [201, 204])) {
            throw new Exception("Error creating resource in  personal space "
                . json_decode($response['body'], true)['error']['message']);
        }
    }

    /**
     * Create a resource in a project space
     * @param string $space
     * @param string $resource
     * @param string $body
     *
     * @return void
     * @throws Exception
     */
    public function create_resource_in_project_space(string $space, string $resource, string $body): void {
        $spaceid = $this->get_space_by_name("Admin", $space)['id'];
        $client = $this->get_admin_client();
        $response = $client->request('PUT', "dav/spaces/$spaceid/$resource", $body);
        if (!in_array($response['statusCode'], [201, 204])) {
            throw new Exception("Error creating resource in  project space "
                . json_decode($response['body'], true)['error']['message']);
            ;
        }
    }

    /**
     * the user id from the user name
     * @param string $username
     *
     * @return string
     * @throws Exception
     */
    private function get_user_id(string $username): string {
        $client = $this->get_admin_client();
        $response = $client->request(
            'GET',
            '/graph/v1.0/users'
        );
        $responsebody = json_decode($response["body"], true);
        foreach ($responsebody["value"] as $createduser) {
            if ($createduser["displayName"] === $username) {
                return $createduser["id"];
            }
        }
        throw new Exception("User $username does not exist", 1);
    }

    /**
     * Create a new user
     * @param string $user
     *
     * @return array
     */
    public function create_new_user(string $user) {
        $username = $this->get_actual_username($user);
        $email = \str_replace(["@", " "], "", $username) . '@owncloud.com';
        $payload['onPremisesSamAccountName'] = $username;
        $payload['passwordProfile'] = ['password' => $this->get_password_for_user($username)];
        $payload['displayName'] = $username;
        $payload['mail'] = $email;
        $payload['accountEnabled'] = true;

        $client = $this->get_admin_client();
        return $client->request(
            'POST',
            '/graph/v1.0/users',
            json_encode($payload)
        );
    }

    /**
     * Get space by name
     * @param string $user
     * @param string $spacename
     *
     * @return array
     */
    public function get_space_by_name(string $user, string $spacename): array {
        $space = [];
        $spacename = ($spacename === "Personal") ? "personal" : "project";
        $client = $this->get_client($user);
        $response = $client->request('GET', 'graph/v1.0/drives');
        $responsebody = json_decode($response['body']);
        foreach ($responsebody->value as $value) {
            if ($value->driveType === $spacename) {
                $space["name"] = $value->name;
                $space['id'] = $value->id;
            }
        };
        return $space;
    }

    /**
     * Get the id of a resource
     * @param string $user
     * @param string $resource
     * @param string $space
     *
     * @return string
     */
    public function get_resource_id(string $user, string $resource, string $space): string {
        $client = $this->get_client($user);
        $spaceid = $this->get_space_by_name($user, $space)['id'];
        $response = $client->request(
            'PROPFIND',
            "/remote.php/dav/spaces/$spaceid/$resource"
        );
        $resbody = simplexml_load_string($response['body']);
        return $resbody->xpath('//oc:fileid')[0];
    }

    /**
     * Send a share invitation
     * @param string $user
     * @param string $sharetype
     * @param string $sharee
     * @param string $space
     * @param string $resource
     *
     * @return array
     */
    public function send_share_invitation(string $user, string $sharetype, string $sharee, string $space, string $resource): array {
        $body = [];
        $roleid = self::VIEWER_ROLE_PERMISSION_ID;
        $shareeid = $this->get_user_id($sharee);
        $spaceid = $this->get_space_by_name($user, $space)['id'];
        $body['roles'] = [$roleid];
        $body['recipients'][] = [
            "@libre.graph.recipient.type" => $sharetype,
            "objectId" => $shareeid,
        ];
        $itemid = $this->get_resource_id($user, $resource, $space);
        $client = $this->get_client($user);
        $response = $client->request(
            'POST',
            "/graph/v1beta1/drives/$spaceid/items/$itemid/invite",
            json_encode($body)
        );
        $resbody = json_decode($response["body"], true);
        $this->lastcreatedshareid = $resbody["value"][0]["id"];
        return $response;
    }

    /**
     * send request to disable sync of share
     * @param string $user
     *
     * @return array
     */
    public function disable_share_sync(string $user): array {
        $itemid = self::SHARES_SPACE_ID . '!' . $this->lastcreatedshareid;
        $client = $this->get_client($user);
        return $client->request(
            'DELETE',
            "/graph/v1beta1/drives/" . self::SHARES_SPACE_ID . "/items/$itemid",
        );
    }

    /**
     * send request to enable sync of share
     * @param string $user
     * @param string $share
     * @param string $offeredby
     * @param string $space
     *
     * @return array
     */
    public function enable_share_sync(string $user, string $share, string $offeredby, string $space): array {
        $itemid = $this->get_resource_id($offeredby, $share, $space);
        $body = [
            "name" => $share,
            "remoteItem" => [
                "id" => $itemid,
            ],
        ];
        $client = $this->get_client($user);
        return $client->request(
            'POST',
            "/graph/v1beta1/drives/" . self::SHARES_SPACE_ID . "/root/children",
            json_encode($body)
        );
    }
}
