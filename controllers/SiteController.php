<?php

namespace app\controllers;
ob_start();
use app\models\Access;
use Yii;
use yii\db\Query;
use yii\web\Controller;

class SiteController extends Controller
{
    use Assistant;
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $public_href_pastes = (new Query())
            ->select([
                'paste_id',
                'short_title',
                'paste_text',
                'date_create',
                'expiration_time',
                'url',
                'access_id'
            ])
            ->from('view_pastes')
            ->where('access_id = 1 AND NOW() < expiration_time')
            ->limit(10)
            ->orderBy(['date_create' => SORT_DESC])
            ->all();
        $accesses = Access::find()->asArray()->all();
        $errors = array();
        $url = $this->getUrl();
        if($url === '')
        {
            return $this->render('create_paste', ['accesses' => $accesses,  'public_href_pastes' => $public_href_pastes]);
        }
        else
        {
            $paste = (new Query())
                ->select([
                    'paste_id',
                    'short_title',
                    'paste_text',
                    'date_create',
                    'expiration_time',
                    'url',
                    'access_id',
                    'status'
                ])
                ->from('view_pastes')
                ->where(['url' => $url])
                ->andWhere('now() < expiration_time AND access_id = 1')
                ->one();
            if(!$paste)
            {
                $errors[] = "Нет такой пасты";
            }
            else{
                $paste['expiration_time'] = $this->dateDiff($paste['expiration_time'], $paste['date_create']);
            }
            return $this->render('show_paste', [
                    'accesses' => $accesses,
                    'errors' => $errors,
                    'paste' => $paste,
                    'public_href_pastes' => $public_href_pastes
                ]);
        }
    }
}
