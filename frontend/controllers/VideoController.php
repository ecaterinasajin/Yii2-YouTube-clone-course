<?php
namespace frontend\controllers;

use common\models\Comment;
use common\models\Video;
use common\models\VideoLike;
use common\models\VideoView;
use yii\base\ViewNotFoundException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class VideoController
 * @package frontend\controllers
 */
class VideoController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['like', 'dislike', 'history'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'like' => ['post'],
                    'dislike' => ['post'],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        //$this->layout = 'main';
        $dataProvider = new ActiveDataProvider([
            //'query' => Video::find()->with('createdBy')->published()->latest(),
            'query' => Video::find()->published()->latest(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($video_id)
    {
        $this->layout = 'main';
        $video = $this->findVideo($video_id);

        $videoView = new VideoView();
        $videoView->video_id = $video_id;
        $videoView->user_id = \Yii::$app->user->id;
        $videoView->created_at = time();
        $videoView->save();

        $similarVideos = Video::find()
            ->published()
            ->byKeyword($video->title)
            ->andWhere(['NOT', ['video_id' => $video_id]])
            ->limit(10)
            ->all();

        /*$comments = $video
            ->getComments()
            ->with(['createdBy'])
            ->parent()
            ->latest()
            ->all();*/

        return $this->render('view', [
            'model' => $video,
            //'comments' => $comments,
            'similarVideos' => $similarVideos
        ]);
    }

    /*public function actionLike($video_id)
    {
        $video = $this->findVideo($video_id);
        $user_id = \Yii::$app->user->id;

        $videoLikeDislike = new VideoLike();

        $videoLikeDislike->video_id = $video_id;
        $videoLikeDislike->user_id = $user_id;
        $videoLikeDislike->type = VideoLike::TYPE_LIKE;
        $videoLikeDislike->created_at = time();
        $videoLikeDislike->save();

        return $this->renderAjax('_buttons', ['model' => $video]);   
    }*/

    public function actionLike($video_id)
    {
        $video = $this->findVideo($video_id);
        $user_id = \Yii::$app->user->id;

        $videoLikeDislike = VideoLike::find()
            ->userIdVideoId($user_id, $video_id)
            ->one();
        if (!$videoLikeDislike) {
            $this->saveLikeDislike($video_id, $user_id, VideoLike::TYPE_LIKE);
        } else if ($videoLikeDislike->type == VideoLike::TYPE_LIKE) {
            $videoLikeDislike->delete();
        } else {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($video_id, $user_id, VideoLike::TYPE_LIKE);
        }

        return $this->renderAjax('_buttons', [
            'model' => $video
        ]);
    }   
    
    public function actionDislike($video_id)
    {
        $video = $this->findVideo($video_id);
        $user_id = \Yii::$app->user->id;

        $videoLikeDislike = VideoLike::find()
            ->userIdVideoId($user_id, $video_id)
            ->one();
        if (!$videoLikeDislike) {
            $this->saveLikeDislike($video_id, $user_id, VideoLike::TYPE_DISLIKE);
        } else if ($videoLikeDislike->type == VideoLike::TYPE_DISLIKE) {
            $videoLikeDislike->delete();
        } else {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($video_id, $user_id, VideoLike::TYPE_DISLIKE);
        }

        return $this->renderAjax('_buttons', [
            'model' => $video
        ]);
    }

    public function actionSearch($keyword)
    {
        $this->layout = 'main';
        $query = Video::find()
            ->with('createdBy')
            ->published()
            ->latest();
        if ($keyword) {
            $query->byKeyword($keyword);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('search', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionHistory()
    {
        $this->layout = 'main';
        $query = Video::find()
            ->alias('v')
            ->innerJoin("(SELECT video_id, MAX(created_at) as max_date FROM video_view
                    WHERE user_id = :userId
                    GROUP BY video_id) vv", 'vv.video_id = v.video_id', [
                'userId' => \Yii::$app->user->id
            ])
            ->orderBy("vv.max_date DESC");

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('history', [
            'dataProvider' => $dataProvider
        ]);
    }

    protected function findVideo($video_id)
    {
        $video = Video::findOne($video_id);
        if (!$video) {
            throw new NotFoundHttpException("Video does not exist");
        }

        return $video;
    }

    protected function saveLikeDislike($video_id, $user_id, $type)
    {
        $videoLikeDislike = new VideoLike();
        $videoLikeDislike->video_id = $video_id;
        $videoLikeDislike->user_id = $user_id;
        $videoLikeDislike->type = $type;
        $videoLikeDislike->created_at = time();
        $videoLikeDislike->save();
    }
}