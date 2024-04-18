<?php

use linslin\yii2\curl;
use yii\db\Migration;
use yii\helpers\Json;

/**
 * Class m240413_192851_add_100_first_texts
 */
class m240413_192851_add_100_first_texts extends Migration
{
    /**
     * @throws Exception
     */
    public function safeUp()
    {
        $curl = new curl\Curl();

        $this->createTable('texts', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
            'lang' => $this->text()->defaultValue('ru-RU'),
            'length' => $this->integer()->notNull(),
        ]);

        foreach (range(1, 5) as $index) {
            $response = $curl->setOption(
                CURLOPT_POSTFIELDS,
                Json::encode([
                    'conversation_id' => '123',
                    'bot_id' => (string)\Yii::$app->params['botId'],
                    'user' => '29032201862555',
                    'query' => '30 10 русский',
                    'stream' => false
                ])
            )->setHeaders([
                'Authorization' => "Bearer" . \Yii::$app->params['authToken'],
                'Content-Type' => 'application/json',
                'Accept' => '*/*',
                'Host' => 'api.coze.com',
                'Connection' => 'keep-alive',
            ])->post('https://api.coze.com/open_api/v2/chat');
            var_dump('t' . (string)$response);
            var_dump('1' . $response['messages']);
            return false;
            if (!empty($response) ) { // Проверка наличия сообщений
                    $texts1 = explode("\n", $response['messages'][0]['content']);
                    foreach ($texts1 as $text) {
                        $textModel = new \frontend\models\Texts();
                        $textModel->text = $text;
                        $textModel->length = 10;
                        $textModel->lang = 'ru-RU';
                        if (!$textModel->save()) { // Проверка успешности сохранения
                            echo "Ошибка при сохранении: " . implode(', ', $textModel->getErrors());
                        }
                    }

            } else {
                echo "Нет сообщений в ответе API";
                return false;
            }
        }
    }

    public function safeDown()
    {
        $this->dropTable('texts');
    }
}
