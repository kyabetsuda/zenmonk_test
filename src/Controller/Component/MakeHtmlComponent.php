<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class MakeHtmlComponent extends Component
{
	public function makeHtmlForPictures($picture)
	{
		return h('<img class="mx-auto d-block" style="max-width:100%" src="/img/uploaded/' . $picture->thumbnail . '">'
			. '<script src="/js/turnPicture.js"></script>');
	}

	public function makeHtmlForArticles($content){
		return h('<div style="max-width:100%">' . $content . '</div>'
			. '<script src="/js/jsForArticle.js"></script>'
		);
	}

	public function makeHtmlForVideos($video){
		return h('<video class="mx-auto d-block" style="max-width:100%" src="/mv/videos/' . $video->content . '" controls></video>'
		);
	}

	// public function makeHtmlForProcessings($processing){
	// 	return h('<script src="/js/processings/' . $processing->title . '.js"></script>'
	// 		.'<div><canvas class="mx-auto d-block" style="max-width:100%" id="processing"></canvas></div>'
	// 	);
	// }
}
