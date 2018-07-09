<?php

/**
 * Class Checkip
 */
class Checkip
{
    /**
     * @var null
     */
    private static $app = null;

    /**
     * Checkip constructor.
     */
    private function __construct()
    {

    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * @return Checkip|string
     * @throws Exception
     */
    public static function init()
    {
        if (null !== self::$app) {
            throw new \Exception('Application is already created');
        }

        return new self();
    }

    /**
     * @return bool|string
     */
    private function sendRequest(string $ip)
    {
        //access api key
        $key = 'MjcwODpCVlE3SkpXY0pHY3ZhUGVUVVNtaXJHdlJEcWZ3bkVmdw==';

        $options = [
            'http' => [
                'method' => "GET",
                'header' => "X-Key: {$key}\r\n"

            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents("http://v2.api.iphub.info/ip/{$ip}", false, $context);

        return $response;
    }
    /**
     * @param string $ip
     * @return string
     * @throws Exception
     */
    public function checkIp(string $ip)
    {
        //ip validation
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new \Exception('IP address value is invalid');
        }

        $response = self::sendRequest($ip);

        if (!$response) {
            throw new \Exception('Not Forbidden 403');
        }

        $block = json_decode($response)->block;

        if ($block === 0 || $block === 2) {
            $rezult = true;
        } else if ($block === 1) {
            $rezult = false;
        }

        return $rezult;
    }
}