<?php namespace Hbsnow\Pshb;

/**
 * A client library for PubSubHubBub.
 *
 * @author  <yuki.4uing@gmail.com>
 */
class Publisher
{
    protected $hubUrl;

    /**
     * Constructor
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->hubUrl = $url;
    }

    /**
     * Push
     *
     * @param array|string $urls
     */
    public function update($urls)
    {
        if (! is_array($urls)) {
            $urls = [$urls];
        }

        foreach ($urls as $url) {
            $post = [
                'hub.mode' => 'publish',
                'hub.url' => $url
            ];

            return $this->post($this->hubUrl, http_build_query($post));
        }
    }

    /**
     * cURLでPost
     *
     * @param string $url
     * @param string $postfields
     */
    private function post($url, $postfields)
    {
        $options = [
            CURLOPT_URL        => $url,
            CURLOPT_POST       => true,
            CURLOPT_POSTFIELDS => $postfields
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] === '204') {
            return true;
        }

        return false;
    }
}
