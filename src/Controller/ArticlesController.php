<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Event\Event; // 追加
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{

	/**
	* initialize
	*
	* @return
	*/
	public function initialize()
	{
	    parent::initialize();
	    $this->loadComponent('MakeHtml');
			$this->Categories = TableRegistry::get('Categories');
			$this->ArticlesCategories = TableRegistry::get('ArticlesCategories');
			$this->Mails = TableRegistry::get('Mails');
	}


	/**
	* izAuthorized
	*
	* @return
	*/
	public function isAuthorized($user)
	{
		return true;

	}

	/**
	* beforeFilter
	*
	* @return
	*/
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Security->setConfig('unlockedActions', [
			'index',
			'getContent',
			'getContentByCategory',
			'uploadArticle',
			'getCategories',
			'plusCategory',
			'delete',
			'getPost'
		]);

		$this->Auth->allow(['index',
			'post',
			'getContent',
			'getContentByCategory',
			'uploadArticle',
			'getCategories',
			'plusCategory',
			'delete',
			'getPost'
		]);
	}

	/**
	* 記事の一覧
	*
	* @return
	*/
	public function index()
	{
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			$conn = ConnectionManager::get('default');
			$stmt = $conn->prepare(
				"select id, title, content, thumbnail, ROW_NUM, upd_ymd, 件数, (case when ROW_NUM=件数 then 'last' when ROW_NUM=1 then 'first' else null end) as 'flg' from ( select id, title, content, thumbnail, upd_ymd, @rownum:=@rownum+1 as ROW_NUM, (select count(*) from articles where draft = '0') as '件数' from articles t11, (SELECT @rownum:=0) AS INDEX_NUM where t11.draft = '0' order by upd_ymd desc) t1 order by ROW_NUM"
			);
			// $stmt->bindValue(':limit', intval($this->request->data['page']), 'integer');
			$stmt->execute();
			$article = $stmt->fetchAll('assoc');
			$resultJ = json_encode($article);
			$this->response->type('json');
			$this->response->body($resultJ);
			return $this->response;
		}else{
			$this->cakeError('error404');
		}
	}

	/**
	* 記事の取得
	*
	* @return
	*/
	public function getContent(){
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			//$articles = $this->Articles->find()->where(['title like' => '%' . $this->request->data['word'] . '%', 'draft' => '0']);
			$conn = ConnectionManager::get('default');
			$stmt = $conn->prepare(
				"select id, title, content, thumbnail, ROW_NUM, upd_ymd, 件数, (case when ROW_NUM=件数 then 'last' when ROW_NUM=1 then 'first' else null end) as 'flg' from ( select id, title, content, thumbnail, upd_ymd, @rownum:=@rownum+1 as ROW_NUM, (select count(*) from articles where draft = '0' and title like :title) as '件数' from articles t11, (SELECT @rownum:=0) AS INDEX_NUM where t11.draft = '0' and t11.title like :title order by upd_ymd desc) t1 order by ROW_NUM"
			);
			// $stmt->bindValue(':limit', intval($this->request->data['page']), 'integer');
			$stmt->bindValue(':title', '%' . $this->request->data['word'] . '%');
			$stmt->execute();
			$articles = $stmt->fetchAll('assoc');
			$resultJ = json_encode($articles);
			$this->response->type('json');
			$this->response->body($resultJ);
			return $this->response;
		}else{
			$this->cakeError('error404');
		}
	}

	public function getContentByCategory(){
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			$conn = ConnectionManager::get('default');
			$stmt = $conn->prepare(
				"select id, title, content, thumbnail, ROW_NUM, upd_ymd, 件数, (case when ROW_NUM=件数 then 'last' when ROW_NUM=1 then 'first' else null end) as 'flg' from (select id, title, content, thumbnail, upd_ymd, @rownum:=@rownum+1 as ROW_NUM, (select count(*) from articles t111, articles_categories t112, categories t113 where t111.draft = '0' and t111.id = t112.article_id and t112.category_id = t113.id and t113.name = :name) as '件数' from (select t111.id, t111.title, t111.content, t111.thumbnail, t111.upd_ymd from articles t111, articles_categories t112, categories t113, (SELECT @rownum:=0) AS INDEX_NUM where t111.draft = '0' and t111.id = t112.article_id and t112.category_id = t113.id and t113.name = :name order by t111.upd_ymd desc) t11) t1 order by ROW_NUM"
			);
			$stmt->bindValue(':name', $this->request->data['word']);
			// $stmt->bindValue(':limit', intval($this->request->data['page']), 'integer');
			$stmt->execute();
			$articles = $stmt->fetchAll('assoc');
			$resultJ = json_encode($articles);
			$this->response->type('json');
			$this->response->body($resultJ);
			return $this->response;
		}else{
			$this->cakeError('error404');
		}
	}

  /**
   * View method
   *
   * @param
   * @return
   * @throws
   */
  public function post()
  {
  }

	/**
   * get post for view
   *
   * @param
   * @return
   * @throws
   */
	 public function getPost(){
		 $this->autoRender = FALSE;
		 if($this->request->is('ajax')) {
 			//$articles = $this->Articles->find()->where(['title like' => '%' . $this->request->data['word'] . '%', 'draft' => '0']);
 			$conn = ConnectionManager::get('default');
 			$stmt = $conn->prepare(
 				'select'
				. ' t1.id as "article_id"'
				. ' ,t1.title'
				. ' ,t1.content'
				. ' ,t3.id as "category_id"'
				. ' ,t3.name as "category_name"'
				. ' from'
				. ' ((articles t1'
				. ' left outer join articles_categories t2 on t1.id = t2.article_id)'
				. ' left outer join categories t3 on t2.category_id = t3.id)'
				. ' where'
				. ' t1.draft = :draft'
				. ' and t1.id = :id'
 			);
 			$stmt->bindValue(':draft', '0');
 			$stmt->bindValue(':id', $this->request->data['no']);
 			$stmt->execute();
 			$results = $stmt->fetchAll('assoc');
			//結果がnullの場合はエラー

			//カテゴリー配列
			$categories = array();
			foreach($results as $result){
				$category = array();
				$category['id'] = $result['category_id'];
				$category['name'] = $result['category_name'];
				$categories[] = $category;
			}
			//返却用$articleの作成
			$article = array();
			$result = $results[0];
			$article['id'] = $result['article_id'];
			$article['title'] = $result['title'];
			$article['content'] = $result['content'];
			$article['categories'] = $categories;
 			$resultJ = json_encode($article);
 			$this->response->type('json');
 			$this->response->body($resultJ);
 			return $this->response;
 		}else{
 			$this->cakeError('error404');
 		}
	 }

  /**
   * Add method
   *
   * @return
   */
  public function add()
  {
      $categories = $this->Categories->find('all');
      $this->set(compact('categories'));
  }


	/**
   * 編集および削除記事リストの表示
   *
   * @return
   */
	public function editOrDeleteList(){
		$secretUrl = Configure::read("secretUrl");
		$conn = ConnectionManager::get('default');
		$stmt = $conn->prepare(
			'select t1.id, t1.title, t1.thumbnail, t1.upd_ymd from articles t1 order by t1.upd_ymd desc'
		);
		$stmt->execute();
		$articles = $stmt->fetchAll('assoc');
		$this->set(compact('articles','secretUrl'));
	}


	/**
   * Edit method
   *
   * @param
   * @return
   * @throws
   */
  public function edit($id = null)
  {
			//記事
      $article = $this->Articles->get($id, [
          'contain' => ['Categories']
      ]);
			//カテゴリ
      $categories = $this->Categories->find('all');
      $this->set(compact('article', 'categories'));
  }


	/**
   * 記事のアップロード(ajax)
   *
   * @param
   * @return
   * @throws
   */
	public function uploadArticle(){
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			if($this->request->data['id'] != null){
				$article = $this->Articles->find()->where(['id' => $this->request->data['id']])->first();
				//articleがnullの場合は新規追加
				if($article == null){
					$article = $this->Articles->newEntity();
				}
			}else{
				//idがそもそも設定されていない場合は新規追加
				$article = $this->Articles->newEntity();
			}

			//各種データ登録
			$article->title = $this->request->data['title'];
			$article->content = $this->request->data['content'];
			$article->thumbnail = $this->request->data['thumbnail'];
			$article->contName = "articles";
			if($this->request->data['draft']  > -1){
				//リクエストのdraftに何か設定されている場合のみ設定(設定されていない場合、かつeditの場合に元の値を保持するため)
				//javascript側で設定されていない場合は初期値-1をそのまま渡すようにしている
				$article->draft = $this->request->data['draft'];
			}

			//更新
			Log::write('debug','before save');
			if ($this->Articles->save($article)) {
				$this->Flash->success(__('The article has been saved.'));
			}else{
				$this->cakeError('error404');
			}
			Log::write('debug','after save');

			//一旦カテゴリーを全部削除する
			$ArticlesCategoriesForDelete = $this->ArticlesCategories->find()->where(['article_id' => $article->id]);
			foreach($ArticlesCategoriesForDelete as $category){
				Log::write('debug','category id is : ' . $category);
				if ($this->ArticlesCategories->delete($category)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->cakeError('error404');
        }
			}

			//カテゴリー登録
			foreach($this->request->data['categories'] as $category){
				$ArticleCategory = $this->ArticlesCategories->newEntity();
				$ArticleCategory->article_id = $article->id;
				$ArticleCategory->category_id = $category;
				if ($this->ArticlesCategories->save($ArticleCategory)) {
				   $this->Flash->success(__('The article has been deleted.'));
				} else {
				   $this->cakeError('error404');
				}
			}


		}else{
			$this->cakeError('error404');
		}
	}

	/**
   * カテゴリーの取得(ajax)
   *
   * @param
   * @return
   * @throws
   */
	public function getCategories(){
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			$categories = $this->Categories->find('all');
			$resultJ = json_encode($categories);
			$this->response->type('json');
			$this->response->body($resultJ);
			return $this->response;
		}else{
			$this->cakeError('error404');
		}
	}

	/**
   * カテゴリーの登録(ajax)
   *
   * @param
   * @return
   * @throws
   */
	public function plusCategory(){
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			$category = $this->Categories->newEntity();
			$category->name = $this->request->data['category'];

			//新規カテゴリー登録
			if ($this->Categories->save($category)) {
					$this->Flash->success(__('The article has been saved.'));
					$categories = $this->Categories->find('all');

					//新しいカテゴリーリストを返却
					$resultJ = json_encode($categories);
	        $this->response->type('json');
	        $this->response->body($resultJ);
	        return $this->response;

			}else{
				$this->cakeError('error404');
			}
		}else{
			$this->cakeError('error404');
		}
	}


  /**
   * Delete method(ajax)
   *
   * @param
   * @return
   * @throws
   */
  public function delete()
  {
			$this->autoRender = FALSE;
      $this->request->allowMethod(['ajax']);
      $article = $this->Articles->get($this->request->data['id']);
      if ($this->Articles->delete($article)) {
          $this->Flash->success(__('The article has been deleted.'));
      } else {
          $this->Flash->error(__('The article could not be deleted. Please, try again.'));
      }
  }

	/**
   * Send a mail method(ajax)
   *
   * @param
   * @return
   * @throws
   */
	// public function sendMail(){
	// 	$this->autoRender = FALSE;
	//
	// 	mb_language("Japanese");
	// 	mb_internal_encoding("UTF-8");
	// 	$to = "junn135246@icloud.com";
	// 	$title = $this->request->data['title'];
	// 	$content = $this->request->data['content'];
	// 	$name = 'From: ' . $this->request->data['name'];
	//
	// 	$mail = $this->Mails->newEntity();
	// 	$mail->name = $name;
	// 	$mail->title = $title;
	// 	$mail->content = $content;
	// 	$mail->remote_address = $_SERVER["REMOTE_ADDR"];
	// 	if (!$this->Mails->save($mail)) {
	// 		$this->response->type('text');
	// 		$this->response->body('メール送信に失敗しました'
	// 			. "\n"
	// 			. '●予想される原因'
	// 			. "\n"
	// 			. 'メールは一日5回までしか送信できません'
	// 		);
	// 		$this->response->statusCode(404);
	// 		return $this->response;
	// 	}
	//
	// 	if(mb_send_mail($to, $title, $content, $name)){
	// 		Log::write('debug','sending mail success');
	// 	} else {
	// 		Log::write('debug','sending mail failed');
	// 	}
	// }

	// public function test(){
	// 	$this->autoRender = FALSE;
	// }
}
