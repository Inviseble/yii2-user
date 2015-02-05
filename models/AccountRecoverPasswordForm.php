<?php

	namespace abhimanyu\user\models;

	use Yii;
	use yii\base\Model;

	class AccountRecoverPasswordForm extends Model
	{
		public $verifyCode;
		public $email;

		public function rules()
		{
			return [
				// email
				['email', 'required'],
				['email', 'email'],
				['email', 'exist', 'targetClass' => User::className(), 'message' => 'Email not found in the system!'],
			];
		}

		public function attributeLabels()
		{
			return [
				'email' => 'Email'
			];
		}

		/**
		 * Sends recovery message.
		 */
		public function recoverPassword()
		{
			$user = User::findOne(['email' => $this->email]);

			if ($user != NULL) {
				$user->password_reset_token = Yii::$app->getSecurity()->generateRandomString();

				$user->save(FALSE);
			}

			// todo send mail
			Yii::$app->session->setFlash('info', 'You will receive an email with instructions on how to reset your password in a few minutes.');
		}
	}