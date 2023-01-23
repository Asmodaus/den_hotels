<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Video\V1;

use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;

class RecordingContext extends InstanceContext {
    /**
     * Initialize the RecordingContext
     * 
     * @param Version $version Version that contains the resource
     * @param string $sid The Recording Sid that uniquely identifies the Recording
     *                    to fetch.
     * @return RecordingContext
     */
    public function __construct(Version $version, $sid) {
        parent::__construct($version);

        // Path Solution
        $this->solution = array('sid' => $sid, );

        $this->uri = '/Recordings/' . rawurlencode($sid) . '';
    }

    /**
     * Fetch a RecordingInstance
     * 
     * @return RecordingInstance Fetched RecordingInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch() {
        $params = Values::of(array());

        $payload = $this->version->fetch(
            'GET',
            $this->uri,
            $params
        );

        return new RecordingInstance($this->version, $payload, $this->solution['sid']);
    }

    /**
     * Deletes the RecordingInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete() {
        return $this->version->delete('delete', $this->uri);
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
        return '[Twilio.Video.V1.RecordingContext ' . implode(' ', $context) . ']';
    }
}