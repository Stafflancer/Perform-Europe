<?php

namespace UserMeta\Field;

use UserMeta\Html\Html;

/**
 * Handle video link field like YouTube or Vimeo.
 *
 * @author Sourov Amin
 * @since 2.4
 */
class VideoLink extends Base
{

    /**
     * Get the embed link from any type of YouTube video URL
     *
     * @param $url
     * @return bool|string
     */
    private function getVideoId($video_type, $url)
    {
        if ($video_type == 'youtube_video') {
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/",
                $url, $videoId);
            if (empty($videoId[1])) {
                return false;
            }
            $video_url = 'https://www.youtube.com/embed/' . $videoId[1];
        }
        elseif ($video_type == 'vimeo_video'){
            preg_match("/https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/",
                $url, $videoId);
            if (empty($videoId[3])) {
                return false;
            }
            $video_url = 'https://player.vimeo.com/video/' . $videoId[3];
        }
        return $video_url;
    }

    protected function _configure()
    {
        $this->inputType = 'url';
        $this->addValidation('custom[url]');
    }

    protected function configure_()
    {
        $this->fieldResult = ' ';
        $width = !empty($this->field['field_size']) ? preg_replace('/\D/', '', $this->field['field_size']) : 300;
        $height = intval($width * .56);
        $type = $this->field['video_type'];

        if ($this->fieldValue) {
            $src = $this->getVideoId($type, $this->fieldValue);
            if (!empty($src)) {
                $this->fieldResult = Html::tag('iframe', '', [
                    'width' => $width,
                    'height' => $height,
                    'src' => $src
                ]);
            }
        }
        $this->inputAttr['onblur'] = "umShowVideo(this, '{$type}', '{$width}', '{$height}')";
    }

}