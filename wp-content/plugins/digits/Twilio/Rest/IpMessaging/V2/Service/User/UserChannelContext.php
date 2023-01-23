<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\IpMessaging\V2\Service\User;

use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;

class UserChannelContext extends InstanceContext {
    /**
     * Initialize the UserChannelContext
     * 
     * @param Version $version Version that contains the resource
     * @param string $serviceSid The unique id of the Service those channels belong
     *                           to.
     * @param string $userSid The unique id of a User.
     * @param string $channelSid The unique id of a Channel.
     * @return UserChannelContext
     */
    public function __construct(Version $version, $serviceSid, $userSid, $channelSid) {
        parent::__construct($version);

        // Path Solution
        $this->solution = array(
            'serviceSid' => $serviceSid,
            'userSid' => $userSid,
            'channelSid' => $channelSid,
        );

        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Users/' . rawurlencode($userSid) . '/Channels/' . rawurlencode($channelSid) . '';
    }

    /**
     * Fetch a UserChannelInstance
     * 
     * @return UserChannelInstance Fetched UserChannelInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch() {
        $params = Values::of(array());

        $payload = $this->version->fetch(
            'GET',
            $this->uri,
            $params
        );

        return new UserChannelInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['userSid'],
            $this->solution['channelSid']
        );
    }

    /**
     * Update the UserChannelInstance
     * 
     * @param string $notificationLevel Push notification level to be assigned to
     *                                  Channel of the User.
     * @return UserChannelInstance Updated UserChannelInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update($notificationLevel) {
        $data = Values::of(array('NotificationLevel' => $notificationLevel, ));

        $payload = $this->version->update(
            'POST',
            $this->uri,
            array(),
            $data
        );

        return new UserChannelInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['userSid'],
            $this->solution['channelSid']
        );
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $context = array();
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.IpMessaging.V2.UserChannelContext ' . implode(' ', $context) . ']';
    }
}