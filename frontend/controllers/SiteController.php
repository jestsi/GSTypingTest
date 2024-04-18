<?php

namespace frontend\controllers;

use linslin\yii2\curl\Curl;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     * @throws \Exception
     */
    public function actionIndex()
    {
        $curl = new Curl();

// Настройка и выполнение POST запроса
        $response = $curl->setOption(
            CURLOPT_POSTFIELDS,
            Json::encode([
                'conversation_id' => '123',
                'bot_id' => \Yii::$app->params['botId'],
                'user' => '29032201862555',
                'query' => 'сгенерируй 50 текстов для speed typing test минимум 30 слов которые легко будет парсить из этого чата на русском',
                'stream' => false
            ])
        )->setHeaders([
            'Authorization' => 'Bearer ' . \Yii::$app->params['authToken'],
            'Content-Type' => 'application/json',
            'Accept' => '*/*',
            'Host' => 'api.coze.com',
            'Connection' => 'keep-alive',
        ])->post('https://api.coze.com/open_api/v2/chat');

        return $this->render('index', ['response' => $response]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
