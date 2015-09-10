<?php
	function GetLanguage()
	{
		if (!isset($_SESSION['lang'])) return 'rus';
		else return $_SESSION['lang'];
	}

	class Language {
		public static function SiteName($lang = 0) {
			if ($lang === 0) $lang = GetLanguage();
			switch ($lang) {
				case 'rus': return 'ЛГМИС';
				case 'eng': return 'LGMIS';				
				default: return 'incorrect language';
			}
		}

		public static function CompanyName($lang = 0) {
			if ($lang === 0) $lang = GetLanguage();
			switch ($lang) {
				case 'rus': return 'Научная группа геометрического моделирования и интерактивных систем факультета ВМК';
				case 'eng': return 'Geometric Modeling and Interactive Systems Research Group at the CMC faculty of Lomonosov Moscow State University';				
				default: return 'incorrect language';
			}
		}

		public static function PublicMenu($item, $lang = 0) {
			if ($lang === 0) $lang = GetLanguage();
			switch ($item) {
				case 'acrticle': {
					switch ($lang) {
						case 'rus': return 'Статья';
						case 'eng': return 'Article';
						default: return 'incorrect language';
					}
				}
				case 'articles': {
					switch ($lang) {
						case 'rus': return 'Новости';
						case 'eng': return 'News';						
						default: return 'incorrect language';
					}
				}
				case 'about_us': {
					switch ($lang) {
						case 'rus': return 'О нас';
						case 'eng': return 'About us';
						default: return 'incorrect language';
					}
				}
				case 'contacts': {
					switch ($lang) {
						case 'rus': return 'Контакты';
						case 'eng': return 'Contacts';						
						default: return 'incorrect language';
					}
				}
				case 'directions': {
					switch ($lang) {
						case 'rus': return 'Направления';
						case 'eng': return 'Directions';						
						default: return 'incorrect language';
					}
				}
				case 'projects': {
					switch ($lang) {
						case 'rus': return 'Проекты';
						case 'eng': return 'Projects';
						default: return 'incorrect language';
					}
				}
				default: return 'incorrect language';
			}
		}

		function Word($word, $lang = 0) {
			if ($lang === 0) $lang = GetLanguage();
			switch ($word) {
				case 'project adding': {
					switch ($lang) {
						case 'rus': return 'Добавление проекта';
						case 'eng': return 'Project adding';
						default: return 'incorrect language';
					}
				}
				case 'error during project inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке проекта в базу';
						case 'eng': return 'Error during project inserting';
						default: return 'incorrect language';
					}
				}
				case 'project is successfully added': {
					switch ($lang) {
						case 'rus': return 'Проект успешно добавлен';
						case 'eng': return 'Project is successfully added';
						default: return 'incorrect language';
					}
				}
				case 'error during project adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении проекта';
						case 'eng': return 'Error during project adding';
						default: return 'incorrect language';
					}
				}
				case 'error during text block inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке текстового блока в базу';
						case 'eng': return 'Error during text block inserting';
						default: return 'incorrect language';
					}
				}
				case 'text block is successfully added': {
					switch ($lang) {
						case 'rus': return 'Текстовый блок успешно добавлен';
						case 'eng': return 'Text block is successfully added';
						default: return 'incorrect language';
					}
				}
				case 'error during text block adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении текстового блока';
						case 'eng': return 'Error during text block adding';
						default: return 'incorrect language';
					}
				}
				case 'error during direction inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке направления в базу';
						case 'eng': return 'Error during direction inserting';
						default: return 'incorrect language';
					}
				}
				case 'direction is successfully added': {
					switch ($lang) {
						case 'rus': return 'Направление успешно добавлено';
						case 'eng': return 'Direction is successfully added';
						default: return 'incorrect language';
					}
				}
				case 'error during direction adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении направления';
						case 'eng': return 'Error during direction adding';
						default: return 'incorrect language';
					}
				}
				case 'error during article inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке новости в базу';
						case 'eng': return 'Error during article inserting';
						default: return 'incorrect language';
					}
				}
				case 'article is successfully added': {
					switch ($lang) {
						case 'rus': return 'Новость успешно добавлена';
						case 'eng': return 'Article is successfully added';
						default: return 'incorrect language';
					}
				}
				case 'request is accepted': {
					switch ($lang) {
						case 'rus': return 'Заявка принята';
						case 'eng': return 'Request is accepted';
						default: return 'incorrect language';
					}
				}
				case 'error while article adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении новости';
						case 'eng': return 'Error while article adding';
						default: return 'incorrect language';
					}
				}
				case 'error during user block inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке блока пользователя в базу';
						case 'eng': return 'Error during user block inserting';
						default: return 'incorrect language';
					}
				}
				case 'user block is successfully added': {
					switch ($lang) {
						case 'rus': return 'Блок пользователя успешно добавлен';
						case 'eng': return 'User block is successfully added';
						default: return 'incorrect language';
					}
				}
				case 'error while user block adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении блока пользователя';
						case 'eng': return 'Error while user block adding';
						default: return 'incorrect language';
					}
				}
				case 'error while user adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении пользователя';
						case 'eng': return 'Error while user adding';
						default: return 'incorrect language';
					}
				}
				case 'adding result': {
					switch ($lang) {
						case 'rus': return 'Результат добавления';
						case 'eng': return 'Adding result';
						default: return 'incorrect language';
					}
				}
				case 'cover was not uploaded': {
					switch ($lang) {
						case 'rus': return 'Обожка не была загружена';
						case 'eng': return 'Cover was not uploaded';
						default: return 'incorrect language';
					}
				}
				case 'photo was not uploaded': {
					switch ($lang) {
						case 'rus': return 'Фото не было загружено';
						case 'eng': return 'Photo was not uploaded';
						default: return 'incorrect language';
					}
				}
				case 'changes are saved': {
					switch ($lang) {
						case 'rus': return 'Изменения сохранены';
						case 'eng': return 'Changes are saved';
						default: return 'incorrect language';
					}
				}
				case 'it was not succeeded to save': {
					switch ($lang) {
						case 'rus': return 'Не удалось сохранить';
						case 'eng': return 'It was not succeeded to save';
						default: return 'incorrect language';
					}
				}
				case 'user was not changed': {
					switch ($lang) {
						case 'rus': return 'Пользователь не был изменен';
						case 'eng': return 'User was not changed';
						default: return 'incorrect language';
					}
				}
				case 'editing is canceled': {
					switch ($lang) {
						case 'rus': return 'Редактирование отменено';
						case 'eng': return 'Editing is canceled';
						default: return 'incorrect language';
					}
				}
				case 'editing result': {
					switch ($lang) {
						case 'rus': return 'Результат редактирования';
						case 'eng': return 'Editing result';
						default: return 'incorrect language';
					}
				}
				case 'text block is deleted': {
					switch ($lang) {
						case 'rus': return 'Текстовый блок удален';
						case 'eng': return 'Text block is deleted';
						default: return 'incorrect language';
					}
				}
				case 'error while text block deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении текстового блока';
						case 'eng': return 'Error while text block deleting';
						default: return 'incorrect language';
					}
				}
				case 'project is deleted': {
					switch ($lang) {
						case 'rus': return 'Проект удален';
						case 'eng': return 'Project is deleted';
						default: return 'incorrect language';
					}
				}
				case 'error while project deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении проекта';
						case 'eng': return 'Error while project deleting';
						default: return 'incorrect language';
					}
				}
				case 'user block is deleted': {
					switch ($lang) {
						case 'rus': return 'Блок пользователя удален';
						case 'eng': return 'User block is deleted';
						default: return 'incorrect language';
					}
				}
				case 'error while user block deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении блока пользователя';
						case 'eng': return 'Error while user block deleting';
						default: return 'incorrect language';
					}
				}
				case 'direction is deleted': {
					switch ($lang) {
						case 'rus': return 'Направление удалено';
						case 'eng': return 'Direction is deleted';
						default: return 'incorrect language';
					}
				}
				case 'error while direction deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении направления';
						case 'eng': return 'Error while direction deleting';
						default: return 'incorrect language';
					}
				}
				case 'article is deleted': {
					switch ($lang) {
						case 'rus': return 'Новость удалена';
						case 'eng': return 'Article is deleted';
						default: return 'incorrect language';
					}
				}
				case 'error while article deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении новости';
						case 'eng': return 'Error while article deleting';
						default: return 'incorrect language';
					}
				}
				case 'user is deleted': {
					switch ($lang) {
						case 'rus': return 'Пользователь удален';
						case 'eng': return 'User is deleted';
						default: return 'incorrect language';
					}
				}
				case 'error while user deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении пользователя';
						case 'eng': return 'Error while user deleting';
						default: return 'incorrect language';
					}
				}
				case 'request is rejected': {
					switch ($lang) {
						case 'rus': return 'Заявка отклонена';
						case 'eng': return 'Request is rejected';
						default: return 'incorrect language';
					}
				}
				case 'error while request rejecting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при отклонении заявки';
						case 'eng': return 'Error while request rejecting';
						default: return 'incorrect language';
					}
				}
				case 'deleting is canceled': {
					switch ($lang) {
						case 'rus': return 'Удаление отменено';
						case 'eng': return 'Deleting is canceled';
						default: return 'incorrect language';
					}
				}
				case 'deleting result': {
					switch ($lang) {
						case 'rus': return 'Результат удаления';
						case 'eng': return 'Deleting result';
						default: return 'incorrect language';
					}
				}
				case 'request was successfully sended': {
					switch ($lang) {
						case 'rus': return 'Request was successfully sended';
						case 'eng': return 'Заявка успешно отправлена';
						default: return 'incorrect language';
					}
				}
				case 'error while inserting register request': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке заявки на регистрацию';
						case 'eng': return 'Error while inserting register request';
						default: return 'incorrect language';
					}
				}
				case 'not all fields are filled': {
					switch ($lang) {
						case 'rus': return 'Не все поля заполнены';
						case 'eng': return 'Not all fields are filled';
						default: return 'incorrect language';
					}
				}
				case 'login': {
					switch ($lang) {
						case 'rus': return 'Войти';
						case 'eng': return 'Login';
						default: return 'incorrect language';
					}
				}
				case 'login please': {
					switch ($lang) {
						case 'rus': return 'Войдите, пожалуйста';
						case 'eng': return 'Login, please';
						default: return 'incorrect language';
					}
				}
				case 'registration': {
					switch ($lang) {
						case 'rus': return 'Регистрация';
						case 'eng': return 'Registration';
						default: return 'incorrect language';
					}
				}
				case 'it was not succeeded to be authorized': {
					switch ($lang) {
						case 'rus': return 'Не удалось авторизироваться';
						case 'eng': return 'It was not succeeded to be authorized';
						default: return 'incorrect language';
					}
				}
				case 'incorrect password': {
					switch ($lang) {
						case 'rus': return 'Неверный пароль';
						case 'eng': return 'Incorrect password';
						default: return 'incorrect password';
					}
				}
				case 'you logout': {
					switch ($lang) {
						case 'rus': return 'Вы вышли';
						case 'eng': return 'You logout';
						default: return 'incorrect language';
					}
				}
				case 'all languages of this user block is implemented': {
					switch ($lang) {
						case 'rus': return 'Все языки этого блока пользователя уже реализованы';
						case 'eng': return 'All languages of this user block is implemented';
						default: return 'incorrect language';
					}
				}
				case 'user block': {
					switch ($lang) {
						case 'rus': return 'Блок пользователя';
						case 'eng': return 'User block';
						default: return 'incorrect language';
					}
				}
				case 'user block editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование блока';
						case 'eng': return 'User block editing';
						default: return 'incorrect language';
					}
				}
				case 'user block adding': {
					switch ($lang) {
						case 'rus': return 'Добавление блока пользователя';
						case 'eng': return 'Adding user block';
						default: return 'incorrect language';
					}
				}
				case 'text block': {
					switch ($lang) {
						case 'rus': return 'Текстовый блок';
						case 'eng': return 'Text block';
						default: return 'incorrect language';
					}
				}
				case 'all languages of this text block is implemented': {
					switch ($lang) {
						case 'rus': return 'Все языки этого текстового блока уже реализованы';
						case 'eng': return 'All languages of this text block is implemented';
						default: return 'incorrect language';
					}
				}
				case 'text editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование текста';
						case 'eng': return 'Text editing';
						default: return 'incorrect language';
					}
				}
				case 'text adding': {
					switch ($lang) {
						case 'rus': return 'Добавление текста';
						case 'eng': return 'Text adding';
						default: return 'incorrect language';
					}
				}
				case 'number': {
					switch ($lang) {
						case 'rus': return 'Число';
						case 'eng': return 'Number';
						default: return 'incorrect language';
					}
				}
				case 'choose role': {
					switch ($lang) {
						case 'rus': return 'Выберите роль';
						case 'eng': return 'Choose role';
						default: return 'incorrect language';
					}
				}
				case 'comment': {
					switch ($lang) {
						case 'rus': return 'Комментарий';
						case 'eng': return 'Comment';
						default: return 'incorrect language';
					}
				}
				case 'project': {
					switch ($lang) {
						case 'rus': return 'Проект';
						case 'eng': return 'Project';
						default: return 'incorrect language';
					}
				}
				case 'all languages of this project is implemented': {
					switch ($lang) {
						case 'rus': return 'Все языки этого направления уже реализованы';
						case 'eng': return 'All languages of this project is implemented';
						default: return 'incorrect language';
					}
				}
				case 'project editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование проекта';
						case 'eng': return 'Project editing';
						default: return 'incorrect language';
					}
				}
				case 'choose direction': {
					switch ($lang) {
						case 'rus': return 'Выберите направление';
						case 'eng': return 'Choose direction';
						default: return 'incorrect language';
					}
				}
				case 'error': {
					switch ($lang) {
						case 'rus': return 'Ошибка';
						case 'eng': return 'Error';
						default: return 'incorrect language';
					}
				}
				case 'add text block': {
					switch ($lang) {
						case 'rus': return 'Добавить блок текста';
						case 'eng': return 'Add text block';
						default: return 'incorrect language';
					}
				}
				case 'add project': {
					switch ($lang) {
						case 'rus': return 'Добавить проект';
						case 'eng': return 'Add project';
						default: return 'incorrect language';
					}
				}
				case 'add direction': {
					switch ($lang) {
						case 'rus': return 'Добавить направление';
						case 'eng': return 'Add direction';
						default: return 'incorrect language';
					}
				}
				case 'absense': {
					switch ($lang) {
						case 'rus': return 'Отсутствуют';
						case 'eng': return 'Absense';
						default: return 'incorrect language';
					}
				}
				case 'add article': {
					switch ($lang) {
						case 'rus': return 'Добавить новость';
						case 'eng': return 'Add article';
						default: return 'incorrect language';
					}
				}
				case 'language adding': {
					switch ($lang) {
						case 'rus': return 'Добавление языка';
						case 'eng': return 'Language adding';
						default: return 'incorrect language';
					}
				}
				case 'all languages of this direction is implemented': {
					switch ($lang) {
						case 'rus': return 'Все языки этого направления уже реализованы';
						case 'eng': return 'All languages of this direction is implemented';
						default: return 'incorrect language';
					}
				}
				case 'all languages of this article is implemented': {
					switch ($lang) {
						case 'rus': return 'Все языки этой новости уже реализованы';
						case 'eng': return 'All languages of this article is implemented';
						default: return 'incorrect language';
					}
				}
				case 'direction editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование направления';
						case 'eng': return 'Direction editing';
						default: return 'incorrect language';
					}
				}
				case 'article editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование новости';
						case 'eng': return 'Article editing';
						default: return 'incorrect language';
					}
				}
				case 'change cover': {
					switch ($lang) {
						case 'rus': return 'Сменить обложку';
						case 'eng': return 'Change cover';
						default: return 'incorrect language';
					}
				}
				case 'direction adding': {
					switch ($lang) {
						case 'rus': return 'Добавление направления';
						case 'eng': return 'Direction adding';
						default: return 'incorrect language';
					}
				}
				case 'article adding': {
					switch ($lang) {
						case 'rus': return 'Добавление новости';
						case 'eng': return 'Article adding';
						default: return 'incorrect language';
					}
				}
				case 'language': {
					switch ($lang) {
						case 'rus': return 'Язык';
						case 'eng': return 'Language';
						default: return 'incorrect language';
					}
				}
				case 'insert annotation text': {
					switch ($lang) {
						case 'rus': return 'Введите текст аннотации';
						case 'eng': return 'Insert annotation text';
						default: return 'incorrect language';
					}
				}
				case 'insert header': {
					switch ($lang) {
						case 'rus': return 'Введите заголовок';
						case 'eng': return 'Insert header';
						default: return 'incorrect language';
					}
				}
				case 'header': {
					switch ($lang) {
						case 'rus': return 'Заголовок';
						case 'eng': return 'Header';
						default: return 'incorrect language';
					}
				}
				case 'our content': {
					switch ($lang) {
						case 'rus': return 'Наш контент';
						case 'eng': return 'Our content';
						default: return 'incorrect language';
					}
				}
				case 'yes': {
					switch ($lang) {
						case 'rus': return 'Да';
						case 'eng': return 'Yes';
						default: return 'incorrect language';
					}
				}
				case 'no': {
					switch ($lang) {
						case 'rus': return 'Нет';
						case 'eng': return 'No';
						default: return 'incorrect language';
					}
				}
				case 'rank': {
					switch ($lang) {
						case 'rus': return 'Ранг';
						case 'eng': return 'Rank';
						default: return 'incorrect language';
					}
				}
				case 'role': {
					switch ($lang) {
						case 'rus': return 'Роль';
						case 'eng': return 'Role';
						default: return 'incorrect language';
					}
				}
				case 'priority': {
					switch ($lang) {
						case 'rus': return 'Приоритет';
						case 'eng': return 'Priority';
						default: return 'incorrect language';
					}
				}
				case 'text': {
					switch ($lang) {
						case 'rus': return 'Текст';
						case 'eng': return 'Text';
						default: return 'incorrect language';
					}
				}
				case 'cover': {
					switch ($lang) {
						case 'rus': return 'Обложка';
						case 'eng': return 'Cover';
						default: return 'incorrect language';
					}
				}
				case 'annotation': {
					switch ($lang) {
						case 'rus': return 'Аннотация';
						case 'eng': return 'Annotation';
						default: return 'incorrect language';
					}
				}
				case 'date': {
					switch ($lang) {
						case 'rus': return 'Дата';
						case 'eng': return 'Date';
						default: return 'incorrect language';
					}
				}
				case 'creating date': {
					switch ($lang) {
						case 'rus': return 'Дата создания';
						case 'eng': return 'Creating date';
						default: return 'incorrect language';
					}
				}
				case 'author': {
					switch ($lang) {
						case 'rus': return 'Автор';
						case 'eng': return 'Author';
						default: return 'incorrect language';
					}
				}
				case 'no annotation': {
					switch ($lang) {
						case 'rus': return 'Нет аннотации';
						case 'eng': return 'No annotation';
						default: return 'incorrect language';
					}
				}
				case 'all linked projects also will be deleted': {
					switch ($lang) {
						case 'rus': return 'Все связанные проекты так же будут удалены';
						case 'eng': return 'All linked projects also will be deleted';
						default: return 'incorrect language';
					}
				}
				case 'are you shure that you want to delete block': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить блок';
						case 'eng': return 'Are you shure that you want to delete block';
						default: return 'incorrect language';
					}
				}
				case 'are you shure that you want to delete text block with header': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить текстовый блок с заголовком';
						case 'eng': return 'Are you shure that you want to delete text block with header';
						default: return 'incorrect language';
					}
				}
				case 'are you shure that yuo want to delete direction with header': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить направление с заголовком';
						case 'eng': return 'Are you shure that yuo want to delete direction with header';
						default: return 'incorrect language';
					}
				}
				case 'are you shure that you want to delete article with header': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить статью с заголовком';
						case 'eng': return 'Are you shure that you want to delete article with header';
						default: return 'incorrect language';
					}
				}
				case 'are you sure that you want to delete user': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить пользователя';
						case 'eng': return 'Are you sure that you want to delete user';
						default: return 'incorrect language';
					}
				}
				case 'are you shure that you want to delete project with header': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить проект с заголовком';
						case 'eng': return 'Are you shure that you want to delete project with header';
						default: return 'incorrect language';
					}
				}
				case 'save': {
					switch ($lang) {
						case 'rus': return 'Сохранить';
						case 'eng': return 'Save';
						default: return 'incorrect language';
					}
				}
				case 'cancel': {
					switch ($lang) {
						case 'rus': return 'Отмена';
						case 'eng': return 'Cancel';
						default: return 'incorrect language';
					}
				}
				case 'upload image': {
					switch ($lang) {
						case 'rus': return 'Загрузить изображение';
						case 'eng': return 'Upload image';
						default: return 'incorrect language';
					}
				}
				case 'no users': {
					switch ($lang) {
						case 'rus': return 'Пользователей нет';
						case 'eng': return 'No users';
						default: return 'incorrect language';
					}
				}
				case 'add block': {
					switch ($lang) {
						case 'rus': return 'Добавить блок';
						case 'eng': return 'Add block';
						default: return 'incorrect language';
					}
				}
				case 'old password': {
					switch ($lang) {
						case 'rus': return 'Старый пароль';
						case 'eng': return 'Old password';						
						default: return 'incorrect language';
					}
				}
				case 'new password': {
					switch ($lang) {
						case 'rus': return 'Новый пароль';
						case 'eng': return 'New password';
						default: return 'incorrect language';
					}
				}
				case 'repeat new password': {
					switch ($lang) {
						case 'rus': return 'Повторите новый пароль';
						case 'eng': return 'Repeat new password';
						default: return 'incorrect language';
					}
				}
				case 'only for password changing': {
					switch ($lang) {
						case 'rus': return 'Только для смены пароля';
						case 'eng': return 'Only for password changing';
						default: return 'incorrect language';
					}
				}
				case 'birthmonth': {
					switch ($lang) {
						case 'rus': return 'Месяц рождения';
						case 'eng': return 'Birthmonth';
						default: return 'incorrect language';
					}
				}
				case 'birthyear': {
					switch ($lang) {
						case 'rus': return 'Год рождения';
						case 'eng': return 'Birthyear';
						default: return 'incorrect language';
					}
				}
				case 'birthday': {
					switch ($lang) {
						case 'rus': return 'День рождения';
						case 'eng': return 'Birthday';
						default: return 'incorrect language';
					}
				}
				case 'insert login': {
					switch ($lang) {
						case 'rus': return 'Введите логин';
						case 'eng': return 'Insert login';
						default: return 'incorrect language';
					}
				}
				case 'login': {
					switch ($lang) {
						case 'rus': return 'Логин';
						case 'eng': return 'Login';
						default: return 'incorrect language';
					}
				}
				case 'insert telephone': {
					switch ($lang) {
						case 'rus': return 'Введите телефон';
						case 'eng': return 'Insert telephone';
						default: return 'incorrect language';
					}
				}
				case 'telephone': {
					switch ($lang) {
						case 'rus': return 'Телефон';
						case 'eng': return 'Telephone';
						default: return 'incorrect language';
					}
				}
				case 'full name': {
					switch ($lang) {
						case 'rus': return 'ФИО';
						case 'eng': return 'Full name';
						default: return 'incorrect language';
					}
				}
				case 'profile edit': {
					switch ($lang) {
						case 'rus': return 'Редактирование профиля';
						case 'eng': return 'Profile editing';
						default: return 'incorrect language';
					}
				}
				case 'insert name': {
					switch ($lang) {
						case 'rus': return 'Введите имя';
						case 'eng': return ' Insert name';
						default: return 'incorrect language';
					}
				}
				case 'insert surname': {
					switch ($lang) {
						case 'rus': return 'Введите фамилию';
						case 'eng': return 'Insert surname';
						default: return 'incorrect language';
					}
				}
				case 'insert fathername': {
					switch ($lang) {
						case 'rus': return 'Введите отчество';
						case 'eng': return 'Insert fathername';
						default: return 'incorrect language';
					}
				}
				case 'fathername': {
					switch ($lang) {
						case 'rus': return 'Отчество';
						case 'eng': return 'Fathername';
						default: return 'incorrect language';
					}
				}
				case 'name': {
					switch ($lang) {
						case 'rus': return 'Имя';
						case 'eng': return 'Name';
						default: return 'incorrect language';
					}
				}
				case 'object name': {
					switch ($lang) {
						case 'rus': return 'Название';
						case 'eng': return 'Name';
						default: return 'incorrect language';
					}
				}
				case 'surname': {
					switch ($lang) {
						case 'rus': return 'Фамилия';
						case 'eng': return 'Surname';
						default: return 'incorrect language';
					}
				}
				case 'our collective': {
					switch ($lang) {
						case 'rus': return 'Наш коллектив';
						case 'eng': return 'Our collective';
						default: return 'incorrect language';
					}
				}
				case 'requests on register': {
					switch ($lang) {
						case 'rus': return 'Заявки на регистрацию';
						case 'eng': return 'Requests on register';
						default: return 'incorrect language';
					}
				}
				case 'content management': {
					switch ($lang) {
						case 'rus': return 'Управление контентом';
						case 'eng': return 'Content management';
						default: return 'incorrect language';
					}
				}
				case 'staff management': {
					switch ($lang) {
						case 'rus': return 'Управление штатом';
						case 'eng': return 'Staff management';
						default: return 'incorrect language';
					}
				}
				case 'main admin page': {
					switch ($lang) {
						case 'rus': return 'Главная';
						case 'eng': return 'Main page';
						default: return 'incorrect language';
					}
				}
				case 'on previous admin page': {
					switch ($lang) {
						case 'rus': return 'На предыдущую страницу';
						case 'eng': return 'On previous page';
						default: return 'incorrect language';
					}
				}
				case 'on start admin page': {
					switch ($lang) {
						case 'rus': return 'На главную страницу';
						case 'eng': return 'On main page';
						default: return 'incorrect language';
					}
				}
				case 'my page': {
					switch ($lang) {
						case 'rus': return 'Моя страница';
						case 'eng': return 'My profile';
						default: return 'incorrect language';
					}
				}
				case 'actions': {
					switch ($lang) {
						case 'rus': return 'Действия';
						case 'eng': return 'Actions';
						default: return 'incorrect language';
					}
				}
				case 'logout': {
					switch ($lang) {
						case 'rus': return 'Выйти';
						case 'eng': return 'Logout';
						default: return 'incorrect language';
					}
				}
				case 'welcome': {
					switch ($lang) {
						case 'rus': return 'Добро пожаловать';
						case 'eng': return 'Welcome';						
						default: return 'incorrect language';
					}
				}
				case 'direction of project': {
					switch ($lang) {
						case 'rus': return 'Направление проекта';
						case 'eng': return 'Direction of project';
						default: return 'incorrect language';
					}
				}
				case 'linked projects': {
					switch ($lang) {
						case 'rus': return 'Связанные проекты';
						case 'eng': return 'Linked projects';
						default: return 'incorrect language';
					}
				}
				case 'insert mail': {
					switch ($lang) {
						case 'rus': return 'Введите почту';
						case 'eng': return 'Insert mail';
						default: return 'incorrect language';
					}
				}
				case 'mail': {
					switch ($lang) {
						case 'rus': return 'Почта';
						case 'eng': return 'Mail';
						default: return 'incorrect language';
					}
				}
				case 'news published': {
					switch ($lang) {
						case 'rus': return 'Новостей опубликовано';
						case 'eng': return 'News published';
						default: return 'incorrect language';
					}
				}
				case 'position': {
					switch ($lang) {
						case 'rus': return 'Должность';
						case 'eng': return 'Position';
						default: return 'incorrect language';
					}
				}
				case 'direction': {
					switch ($lang) {
						case 'rus': return 'Направление';
						case 'eng': return 'Direction';
						default: return 'incorrect language';
					}
				}
				case 'employees': {
					switch ($lang) {
						case 'rus': return 'Сотрудники';
						case 'eng': return 'Employees';
						default: return 'incorrect language';
					}
				}
				case 'open profile': {
					switch ($lang) {
						case 'rus': return 'Открыть профиль';
						case 'eng': return 'Open profile';
						default: return 'incorrect language';
					}
				}
				case 'learn more': {
					switch ($lang) {
						case 'rus': return 'Узнать больше';
						case 'eng': return 'Learn more';
						default: return 'incorrect language';
					}
				}
				case 'no news': {
					switch ($lang) {
						case 'rus': return 'Новостей пока нет';
						case 'eng': return "News aren't present so far";
						default: return 'incorrect language';
					}
				}
				case 'no directions': {
					switch ($lang) {
						case 'rus': return 'Направлений пока нет';
						case 'eng': return "Directions aren't present so far";
						default: return 'incorrect language';
					}
				}
				case 'no projects': {
					switch ($lang) {
						case 'rus': return 'Проектов пока нет';
						case 'eng': return "Projects aren't present so far";
						default: return 'incorrect language';
					}
				}
				default: return 'incorrect word';
			}
		}

		function Position($pos, $lang = 0) {
			if ($lang === 0) $lang = GetLanguage();
			switch ($pos) {
				case 0: {
					switch ($lang) {
						case 'rus': return 'Администратор';
						case 'eng': return 'Administrator';
						default: return 'incorrect language';
					}
				}
				case 1: {
					switch ($lang) {
						case 'rus': return 'Не сотрудник';
						case 'eng': return 'Not employee';
						default: return 'incorrect language';
					}
				}
				case 10: {
					switch ($lang) {
						case 'rus': return 'Новичок';
						case 'eng': return 'Newcomer';
						default: return 'incorrect language';
					}
				}
				case 20: {
					switch ($lang) {
						case 'rus': return 'Стажер';
						case 'eng': return 'Probationer';
						default: return 'incorrect language';
					}
				}
				case 30: {
					switch ($lang) {
						case 'rus': return 'Программист';
						case 'eng': return 'Programmer';
						default: return 'incorrect language';
					}
				}
				case 40: {
					switch ($lang) {
						case 'rus': return 'Старший программист';
						case 'eng': return 'Senior programmer';
						default: return 'incorrect language';
					}
				}
				case 50: {
					switch ($lang) {
						case 'rus': return 'Ведущий программист';
						case 'eng': return 'Leading programmer';
						default: return 'incorrect language';
					}
				}
				case 60: {
					switch ($lang) {
						case 'rus': return 'Руководитель';
						case 'eng': return 'Executive head';
						default: return 'incorrect language';
					}
				}
				default: return 'incorrect position';
			}
		}

		function Translit($str, $from = 'rus', $to = 0) {
			if ($to === 0) $to = GetLanguage();
			if ($from === $to) return $str;
		    $converter = array(
		        'а' => 'a',   'б' => 'b',   'в' => 'v',
		        'г' => 'g',   'д' => 'd',   'е' => 'e',
		        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
		        'и' => 'i',   'й' => 'y',   'к' => 'k',
		        'л' => 'l',   'м' => 'm',   'н' => 'n',
		        'о' => 'o',   'п' => 'p',   'р' => 'r',
		        'с' => 's',   'т' => 't',   'у' => 'u',
		        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
		        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
		        
		        'А' => 'A',   'Б' => 'B',   'В' => 'V',
		        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
		        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
		        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		        'О' => 'O',   'П' => 'P',   'Р' => 'R',
		        'С' => 'S',   'Т' => 'T',   'У' => 'U',
		        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
		        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
		        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
		        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		    );
		    return strtr($str, $converter);
		}

		function ActionTypeToText($action, $lang = 0) {
			if ($lang === 0) $lang = GetLanguage();
			switch ($action) {
				case 'del': {
					switch ($lang) {
						case 'rus': return 'Удалить';
						case 'eng': return 'Delete';
						default: return 'incorrect language';
					}
				}
				case 'add': {
					switch ($lang) {
						case 'rus': return 'Добавить';
						case 'eng': return 'Add';
						default: return 'incorrect language';
					}
				}
				case 'edit': {
					switch ($lang) {
						case 'rus': return 'Редактировать';
						case 'eng': return 'Edit';
						default: return 'incorrect language';
					}
				}
				case 'full': {
					switch ($lang) {
						case 'rus': return 'Подробнее';
						case 'eng': return 'Detailed';
						default: return 'incorrect language';
					}
				}
				case 'add_lang': {
					switch ($lang) {
						case 'rus': return 'Добавить язык';
						case 'eng': return 'Add language';
						default: return 'incorrect language';
					}
				}
				default: return 'incorrect action';
			}
		}

		function GetPositions($lang = 0) {
			if ($lang === 0) $lang = GetLanguage();
			global $positions;
			$positions = array(
				1 => Language::Position(1, $lang),
				10 => Language::Position(10, $lang),
				20 => Language::Position(20, $lang),
				30 => Language::Position(30, $lang),
				40 => Language::Position(40, $lang),
				50 => Language::Position(50, $lang),
				60 => Language::Position(60, $lang),
			);
			return $positions;
		}

		function Address($lang = 0) {
			if ($lang === 0) $lang = GetLanguage();
			switch ($lang) {
				case 'rus': return '119991 ГСП-1 Москва, Ленинские горы, МГУ имени М.В. Ломоносова, 2-й учебный корпус, факультет ВМК, этаж 5, аудитория 528<br><br>Телефон: 8-495-930-52-87';
				case 'eng': return '119991 GSP-1 Moscow, Leninskie Gory, Lomonosov MSU, 2-th study case, CMC faculty, 5-th floor, audience 528<br><br>Telephone: 8-495-930-52-87';				
				default: return 'incorrect language';
			}
		}
	}
?>