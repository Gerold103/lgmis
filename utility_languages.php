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
						case 'eng': return 'Research areas';						
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
			if (($lang !== 'rus') && ($lang !== 'eng')) return 'incorrect language';
			switch ($word) {

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ A ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'absense': {
					switch ($lang) {
						case 'rus': return 'Отсутствуют';
						case 'eng': return 'Absense';
					}
				}
				case 'actions': {
					switch ($lang) {
						case 'rus': return 'Действия';
						case 'eng': return 'Actions';
					}
				}
				case 'add article': {
					switch ($lang) {
						case 'rus': return 'Добавить новость';
						case 'eng': return 'Add article';
					}
				}
				case 'add block': {
					switch ($lang) {
						case 'rus': return 'Добавить блок';
						case 'eng': return 'Add block';
					}
				}
				case 'add direction': {
					switch ($lang) {
						case 'rus': return 'Добавить направление';
						case 'eng': return 'Add direction';
					}
				}
				case 'add project': {
					switch ($lang) {
						case 'rus': return 'Добавить проект';
						case 'eng': return 'Add project';
					}
				}
				case 'add text block': {
					switch ($lang) {
						case 'rus': return 'Добавить блок текста';
						case 'eng': return 'Add text block';
					}
				}
				case 'adding result': {
					switch ($lang) {
						case 'rus': return 'Результат добавления';
						case 'eng': return 'Adding result';
					}
				}
				case 'all languages of this article is implemented': {
					switch ($lang) {
						case 'rus': return 'Все языки этой новости уже реализованы';
						case 'eng': return 'All languages of this article is implemented';
					}
				}
				case 'all languages of this direction is implemented': {
					switch ($lang) {
						case 'rus': return 'Все языки этого направления уже реализованы';
						case 'eng': return 'All languages of this direction is implemented';
					}
				}
				case 'all languages of this project is implemented': {
					switch ($lang) {
						case 'rus': return 'Все языки этого направления уже реализованы';
						case 'eng': return 'All languages of this project is implemented';
					}
				}
				case 'all languages of this text block is implemented': {
					switch ($lang) {
						case 'rus': return 'Все языки этого текстового блока уже реализованы';
						case 'eng': return 'All languages of this text block is implemented';
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
				case 'all linked projects also will be deleted': {
					switch ($lang) {
						case 'rus': return 'Все связанные проекты так же будут удалены';
						case 'eng': return 'All linked projects also will be deleted';
					}
				}
				case 'annotation': {
					switch ($lang) {
						case 'rus': return 'Аннотация';
						case 'eng': return 'Annotation';
					}
				}
				case 'are you shure that you want to delete article with header': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить статью с заголовком';
						case 'eng': return 'Are you shure that you want to delete article with header';
					}
				}
				case 'are you shure that you want to delete block': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить блок';
						case 'eng': return 'Are you shure that you want to delete block';
					}
				}
				case 'are you shure that yuo want to delete direction with header': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить направление с заголовком';
						case 'eng': return 'Are you shure that yuo want to delete direction with header';
					}
				}
				case 'are you shure that you want to delete project with header': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить проект с заголовком';
						case 'eng': return 'Are you shure that you want to delete project with header';
					}
				}
				case 'are you shure that you want to delete text block with header': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить текстовый блок с заголовком';
						case 'eng': return 'Are you shure that you want to delete text block with header';
					}
				}
				case 'are you sure that you want to delete user': {
					switch ($lang) {
						case 'rus': return 'Вы уверены, что хотите удалить пользователя';
						case 'eng': return 'Are you sure that you want to delete user';
					}
				}
				case 'article adding': {
					switch ($lang) {
						case 'rus': return 'Добавление новости';
						case 'eng': return 'Article adding';
					}
				}
				case 'article editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование новости';
						case 'eng': return 'Article editing';
					}
				}
				case 'article is deleted': {
					switch ($lang) {
						case 'rus': return 'Новость удалена';
						case 'eng': return 'Article is deleted';
					}
				}
				case 'article is successfully added': {
					switch ($lang) {
						case 'rus': return 'Новость успешно добавлена';
						case 'eng': return 'Article is successfully added';
					}
				}
				case 'author': {
					switch ($lang) {
						case 'rus': return 'Автор';
						case 'eng': return 'Author';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ B ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'birthday': {
					switch ($lang) {
						case 'rus': return 'День рождения';
						case 'eng': return 'Birthday';
					}
				}
				case 'birthmonth': {
					switch ($lang) {
						case 'rus': return 'Месяц рождения';
						case 'eng': return 'Birthmonth';
					}
				}
				case 'birthyear': {
					switch ($lang) {
						case 'rus': return 'Год рождения';
						case 'eng': return 'Birthyear';
					}
				}
				case 'bookkeeping': {
					switch ($lang) {
						case 'rus': return 'Бухгалтерия';
						case 'eng': return 'Bookkeeping';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ C ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'cancel': {
					switch ($lang) {
						case 'rus': return 'Отмена';
						case 'eng': return 'Cancel';
					}
				}
				case 'change cover': {
					switch ($lang) {
						case 'rus': return 'Сменить обложку';
						case 'eng': return 'Change cover';
					}
				}
				case 'change file': {
					switch ($lang) {
						case 'rus': return 'Изменить файл';
						case 'eng': return 'Change file';
					}
				}
				case 'change receiver': {
					switch ($lang) {
						case 'rus': return 'Изменить получателя';
						case 'eng': return 'Change receiver';
					}
				}
				case 'changes are saved': {
					switch ($lang) {
						case 'rus': return 'Изменения сохранены';
						case 'eng': return 'Changes are saved';
					}
				}
				case 'choose direction': {
					switch ($lang) {
						case 'rus': return 'Выберите направление';
						case 'eng': return 'Choose direction';
					}
				}
				case 'choose receiver': {
					switch ($lang) {
						case 'rus': return 'Выберите получателя';
						case 'eng': return 'Choose receiver';
					}
				}
				case 'choose role': {
					switch ($lang) {
						case 'rus': return 'Выберите роль';
						case 'eng': return 'Choose role';
					}
				}
				case 'comment': {
					switch ($lang) {
						case 'rus': return 'Комментарий';
						case 'eng': return 'Comment';
					}
				}
				case 'comment for request': {
					switch ($lang) {
						case 'rus': return 'Комментарий к заявке';
						case 'eng': return 'Comment for request';
					}
				}
				case 'content management': {
					switch ($lang) {
						case 'rus': return 'Управление контентом';
						case 'eng': return 'Content management';
					}
				}
				case 'cover': {
					switch ($lang) {
						case 'rus': return 'Обложка';
						case 'eng': return 'Cover';
					}
				}
				case 'cover was not uploaded': {
					switch ($lang) {
						case 'rus': return 'Обожка не была загружена';
						case 'eng': return 'Cover was not uploaded';
					}
				}
				case 'creating date': {
					switch ($lang) {
						case 'rus': return 'Дата создания';
						case 'eng': return 'Creating date';
					}
				}
				case 'current file': {
					switch ($lang) {
						case 'rus': return 'Прикрепленный файл';
						case 'eng': return 'Current file';
					}
				}
				case 'current receiver': {
					switch ($lang) {
						case 'rus': return 'Установленный получатель';
						case 'eng': return 'Current receiver';
					}
				}


				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ D ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'date': {
					switch ($lang) {
						case 'rus': return 'Дата';
						case 'eng': return 'Date';
					}
				}
				case 'deleting is canceled': {
					switch ($lang) {
						case 'rus': return 'Удаление отменено';
						case 'eng': return 'Deleting is canceled';
					}
				}
				case 'deleting result': {
					switch ($lang) {
						case 'rus': return 'Результат удаления';
						case 'eng': return 'Deleting result';
					}
				}
				case 'direction': {
					switch ($lang) {
						case 'rus': return 'Направление';
						case 'eng': return 'Direction';
					}
				}
				case 'direction adding': {
					switch ($lang) {
						case 'rus': return 'Добавление направления';
						case 'eng': return 'Direction adding';
					}
				}
				case 'direction editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование направления';
						case 'eng': return 'Direction editing';
					}
				}
				case 'direction is deleted': {
					switch ($lang) {
						case 'rus': return 'Направление удалено';
						case 'eng': return 'Direction is deleted';
					}
				}
				case 'direction is successfully added': {
					switch ($lang) {
						case 'rus': return 'Направление успешно добавлено';
						case 'eng': return 'Direction is successfully added';
					}
				}
				case 'direction of project': {
					switch ($lang) {
						case 'rus': return 'Направление проекта';
						case 'eng': return 'Direction of project';
					}
				}
				case 'download file': {
					switch ($lang) {
						case 'rus': return 'Скачать файл';
						case 'eng': return 'Download file';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ E ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'editing is canceled': {
					switch ($lang) {
						case 'rus': return 'Редактирование отменено';
						case 'eng': return 'Editing is canceled';
					}
				}
				case 'editing result': {
					switch ($lang) {
						case 'rus': return 'Результат редактирования';
						case 'eng': return 'Editing result';
					}
				}
				case 'employees': {
					switch ($lang) {
						case 'rus': return 'Сотрудники';
						case 'eng': return 'Our team';
					}
				}
				case 'error': {
					switch ($lang) {
						case 'rus': return 'Ошибка';
						case 'eng': return 'Error';
					}
				}
				case 'error during article inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке новости в базу';
						case 'eng': return 'Error during article inserting';
					}
				}
				case 'error during direction adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении направления';
						case 'eng': return 'Error during direction adding';
					}
				}
				case 'error during direction inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке направления в базу';
						case 'eng': return 'Error during direction inserting';
					}
				}
				case 'error during project adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении проекта';
						case 'eng': return 'Error during project adding';
					}
				}
				case 'error during project inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке проекта в базу';
						case 'eng': return 'Error during project inserting';
					}
				}
				case 'error during text block adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении текстового блока';
						case 'eng': return 'Error during text block adding';
					}
				}
				case 'error during text block inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке текстового блока в базу';
						case 'eng': return 'Error during text block inserting';
					}
				}
				case 'error during user block inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке блока пользователя в базу';
						case 'eng': return 'Error during user block inserting';
					}
				}
				case 'error while article adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении новости';
						case 'eng': return 'Error while article adding';
					}
				}
				case 'error while article deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении новости';
						case 'eng': return 'Error while article deleting';
					}
				}
				case 'error while direction deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении направления';
						case 'eng': return 'Error while direction deleting';
					}
				}
				case 'error while inserting register request': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке заявки на регистрацию';
						case 'eng': return 'Error while inserting register request';
					}
				}
				case 'error while project deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении проекта';
						case 'eng': return 'Error while project deleting';
					}
				}
				case 'error while report inserting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при вставке отчета в базу';
						case 'eng': return 'Error while report inserting to base';
					}
				}
				case 'error while report sending': {
					switch ($lang) {
						case 'rus': return 'Ошибка при отправке отчета';
						case 'eng': return 'Error while report sending';
					}
				}
				case 'error while request rejecting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при отклонении заявки';
						case 'eng': return 'Error while request rejecting';
					}
				}
				case 'error while text block deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении текстового блока';
						case 'eng': return 'Error while text block deleting';
					}
				}
				case 'error while user adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении пользователя';
						case 'eng': return 'Error while user adding';
					}
				}
				case 'error while user block adding': {
					switch ($lang) {
						case 'rus': return 'Ошибка при добавлении блока пользователя';
						case 'eng': return 'Error while user block adding';
					}
				}
				case 'error while user block deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении блока пользователя';
						case 'eng': return 'Error while user block deleting';
					}
				}
				case 'error while user deleting': {
					switch ($lang) {
						case 'rus': return 'Ошибка при удалении пользователя';
						case 'eng': return 'Error while user deleting';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ F ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'fathername': {
					switch ($lang) {
						case 'rus': return 'Отчество';
						case 'eng': return 'Fathername';
					}
				}
				case 'file': {
					switch ($lang) {
						case 'rus': return 'Файл';
						case 'eng': return 'File';
					}
				}
				case 'full name': {
					switch ($lang) {
						case 'rus': return 'ФИО';
						case 'eng': return 'Full name';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ G ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ H ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'header': {
					switch ($lang) {
						case 'rus': return 'Заголовок';
						case 'eng': return 'Header';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ I ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'incorrect email': {
					switch ($lang) {
						case 'rus': return 'Некорректная почта';
						case 'eng': return 'Incorrect email';
					}
				}
				case 'incorrect fathername': {
					switch ($lang) {
						case 'rus': return 'Некорректное отчество';
						case 'eng': return 'Incorrect fathername';
					}
				}
				case 'incorrect login': {
					switch ($lang) {
						case 'rus': return 'Некорректный логин';
						case 'eng': return 'Incorrect login';
					}
				}
				case 'incorrect name': {
					switch ($lang) {
						case 'rus': return 'Неверное имя';
						case 'eng': return 'Incorrect name';
					}
				}
				case 'incorrect password': {
					switch ($lang) {
						case 'rus': return 'Неверный пароль';
						case 'eng': return 'Incorrect password';
					}
				}
				case 'incorrect phone': {
					switch ($lang) {
						case 'rus': return 'Некорректный телефон';
						case 'eng': return 'Incorrect phone';
					}
				}
				case 'incorrect surname': {
					switch ($lang) {
						case 'rus': return 'Некорректная фамилия';
						case 'eng': return 'Incorrect surname';
					}
				}
				case 'insert annotation text': {
					switch ($lang) {
						case 'rus': return 'Введите текст аннотации';
						case 'eng': return 'Insert annotation text';
					}
				}
				case 'insert fathername': {
					switch ($lang) {
						case 'rus': return 'Введите отчество';
						case 'eng': return 'Insert fathername';
					}
				}
				case 'insert header': {
					switch ($lang) {
						case 'rus': return 'Введите заголовок';
						case 'eng': return 'Insert header';
					}
				}
				case 'insert login': {
					switch ($lang) {
						case 'rus': return 'Введите логин';
						case 'eng': return 'Insert login';
					}
				}
				case 'insert mail': {
					switch ($lang) {
						case 'rus': return 'Введите почту';
						case 'eng': return 'Insert mail';
					}
				}
				case 'insert name': {
					switch ($lang) {
						case 'rus': return 'Введите имя';
						case 'eng': return ' Insert name';
					}
				}
				case 'insert password': {
					switch ($lang) {
						case 'rus': return 'Введите пароль';
						case 'eng': return 'Insert password';
					}
				}
				case 'insert surname': {
					switch ($lang) {
						case 'rus': return 'Введите фамилию';
						case 'eng': return 'Insert surname';
					}
				}
				case 'insert telephone': {
					switch ($lang) {
						case 'rus': return 'Введите телефон';
						case 'eng': return 'Insert telephone';
					}
				}
				case 'internal server error': {
					switch ($lang) {
						case 'rus': return 'Внутренняя ошибка сервера';
						case 'eng': return 'Internal server error';
					}
				}
				case 'it was not succeeded to be authorized': {
					switch ($lang) {
						case 'rus': return 'Не удалось авторизироваться';
						case 'eng': return 'It was not succeeded to be authorized';
					}
				}
				case 'it was not succeeded to save': {
					switch ($lang) {
						case 'rus': return 'Не удалось сохранить';
						case 'eng': return 'It was not succeeded to save';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ J ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ K ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ L ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'language': {
					switch ($lang) {
						case 'rus': return 'Язык';
						case 'eng': return 'Language';
					}
				}
				case 'language adding': {
					switch ($lang) {
						case 'rus': return 'Добавление языка';
						case 'eng': return 'Language adding';
					}
				}	
				case 'learn more': {
					switch ($lang) {
						case 'rus': return 'Узнать больше';
						case 'eng': return 'Learn more';
					}
				}
				case 'linked projects': {
					switch ($lang) {
						case 'rus': return 'Связанные проекты';
						case 'eng': return 'Linked projects';
					}
				}
				case 'a login': {
					switch ($lang) {
						case 'rus': return 'Логин';
						case 'eng': return 'Login';
					}
				}
				case 'login': {
					switch ($lang) {
						case 'rus': return 'Войти';
						case 'eng': return 'Login';
					}
				}
				case 'login please': {
					switch ($lang) {
						case 'rus': return 'Войдите, пожалуйста';
						case 'eng': return 'Login, please';
					}
				}
				case 'logout': {
					switch ($lang) {
						case 'rus': return 'Выйти';
						case 'eng': return 'Logout';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ M ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'mail': {
					switch ($lang) {
						case 'rus': return 'Почта';
						case 'eng': return 'Mail';
					}
				}
				case 'main admin page': {
					switch ($lang) {
						case 'rus': return 'Главная';
						case 'eng': return 'Main page';
					}
				}
				case 'my page': {
					switch ($lang) {
						case 'rus': return 'Моя страница';
						case 'eng': return 'My profile';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ N ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'name': {
					switch ($lang) {
						case 'rus': return 'Имя';
						case 'eng': return 'Name';
					}
				}
				case 'new password': {
					switch ($lang) {
						case 'rus': return 'Новый пароль';
						case 'eng': return 'New password';
					}
				}
				case 'news published': {
					switch ($lang) {
						case 'rus': return 'Новостей опубликовано';
						case 'eng': return 'News published';
					}
				}
				case 'no': {
					switch ($lang) {
						case 'rus': return 'Нет';
						case 'eng': return 'No';
					}
				}
				case 'no annotation': {
					switch ($lang) {
						case 'rus': return 'Нет аннотации';
						case 'eng': return 'No annotation';
					}
				}
				case 'no directions': {
					switch ($lang) {
						case 'rus': return 'Направлений пока нет';
						case 'eng': return "Directions aren't present so far";
					}
				}
				case 'no projects': {
					switch ($lang) {
						case 'rus': return 'Проектов пока нет';
						case 'eng': return "Projects aren't present so far";
					}
				}
				case 'no news': {
					switch ($lang) {
						case 'rus': return 'Новостей пока нет';
						case 'eng': return "News aren't present so far";
					}
				}
				case 'no translation for this article': {
					switch ($lang) {
						case 'rus': return 'Нет перевода для этой новости';
						case 'eng': return 'No translation for this article';
					}
				}
				case 'no translation for this direction': {
					switch ($lang) {
						case 'rus': return 'Нет перевода для этого направления';
						case 'eng': return 'No translation for this direction';
					}
				}
				case 'no translation for this project': {
					switch ($lang) {
						case 'rus': return 'Нет перевода для этого проекта';
						case 'eng': return 'No translation for this project';
					}
				}
				case 'no users': {
					switch ($lang) {
						case 'rus': return 'Пользователей нет';
						case 'eng': return 'No users';
					}
				}
				case 'not all fields are filled': {
					switch ($lang) {
						case 'rus': return 'Не все поля заполнены';
						case 'eng': return 'Not all fields are filled';
					}
				}
				case 'number': {
					switch ($lang) {
						case 'rus': return 'Число';
						case 'eng': return 'Number';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ O ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'object name': {
					switch ($lang) {
						case 'rus': return 'Название';
						case 'eng': return 'Name';
					}
				}
				case 'old password': {
					switch ($lang) {
						case 'rus': return 'Старый пароль';
						case 'eng': return 'Old password';						
					}
				}
				case 'on previous admin page': {
					switch ($lang) {
						case 'rus': return 'На предыдущую страницу';
						case 'eng': return 'On previous page';
					}
				}
				case 'on start admin page': {
					switch ($lang) {
						case 'rus': return 'На главную страницу';
						case 'eng': return 'On main page';
					}
				}
				case 'only for password changing': {
					switch ($lang) {
						case 'rus': return 'Только для смены пароля';
						case 'eng': return 'Only for password changing';
					}
				}
				case 'open profile': {
					switch ($lang) {
						case 'rus': return 'Открыть профиль';
						case 'eng': return 'Open profile';
					}
				}
				case 'our collective': {
					switch ($lang) {
						case 'rus': return 'Наш коллектив';
						case 'eng': return 'Our group';
					}
				}
				case 'our content': {
					switch ($lang) {
						case 'rus': return 'Наш контент';
						case 'eng': return 'Our content';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ P ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'password': {
					switch ($lang) {
						case 'rus': return 'Пароль';
						case 'eng': return 'Password';
					}
				}
				case 'photo was not uploaded': {
					switch ($lang) {
						case 'rus': return 'Фото не было загружено';
						case 'eng': return 'Photo was not uploaded';
					}
				}
				case 'position': {
					switch ($lang) {
						case 'rus': return 'Должность';
						case 'eng': return 'Position';
					}
				}
				case 'priority': {
					switch ($lang) {
						case 'rus': return 'Приоритет';
						case 'eng': return 'Priority';
					}
				}
				case 'private office': {
					switch ($lang) {
						case 'rus': return 'Личный кабинет';
						case 'eng': return 'My account';						
					}
				}
				case 'profile edit': {
					switch ($lang) {
						case 'rus': return 'Редактирование профиля';
						case 'eng': return 'Profile editing';
					}
				}
				case 'project': {
					switch ($lang) {
						case 'rus': return 'Проект';
						case 'eng': return 'Project';
					}
				}
				case 'project adding': {
					switch ($lang) {
						case 'rus': return 'Добавление проекта';
						case 'eng': return 'Project adding';
					}
				}
				case 'project editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование проекта';
						case 'eng': return 'Project editing';
					}
				}
				case 'project is deleted': {
					switch ($lang) {
						case 'rus': return 'Проект удален';
						case 'eng': return 'Project is deleted';
					}
				}
				case 'project is successfully added': {
					switch ($lang) {
						case 'rus': return 'Проект успешно добавлен';
						case 'eng': return 'Project is successfully added';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Q ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ R ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'rank': {
					switch ($lang) {
						case 'rus': return 'Ранг';
						case 'eng': return 'Rank';
					}
				}
				case 'received reports': {
					switch ($lang) {
						case 'rus': return 'Полученные отчеты';
						case 'eng': return 'Received reports';
					}
				}
				case 'receiver': {
					switch ($lang) {
						case 'rus': return 'Получатель';
						case 'eng': return 'Receiver';
					}
				}
				case 'registration': {
					switch ($lang) {
						case 'rus': return 'Регистрация';
						case 'eng': return 'Registration';
					}
				}
				case 'repeat new password': {
					switch ($lang) {
						case 'rus': return 'Повторите новый пароль';
						case 'eng': return 'Repeat new password';
					}
				}
				case 'report': {
					switch ($lang) {
						case 'rus': return 'Отчет';
						case 'eng': return 'Report';
					}
				}
				case 'report editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование отчета';
						case 'eng': return 'Report editing';
					}
				}
				case 'report is successfully sended': {
					switch ($lang) {
						case 'rus': return 'Отчет успешно отправлен';
						case 'eng': return 'Report is successfully sended';
					}
				}
				case 'report sending': {
					switch ($lang) {
						case 'rus': return 'Отправка отчета';
						case 'eng': return 'Report sending';
					}
				}
				case 'reports': {
					switch ($lang) {
						case 'rus': return 'Отчеты';
						case 'eng': return 'Reports';
					}
				}
				case 'request is accepted': {
					switch ($lang) {
						case 'rus': return 'Заявка принята';
						case 'eng': return 'Request is accepted';
					}
				}
				case 'request is rejected': {
					switch ($lang) {
						case 'rus': return 'Заявка отклонена';
						case 'eng': return 'Request is rejected';
					}
				}
				case 'request was successfully sended': {
					switch ($lang) {
						case 'rus': return 'Request was successfully sended';
						case 'eng': return 'Заявка успешно отправлена';
					}
				}
				case 'requests on register': {
					switch ($lang) {
						case 'rus': return 'Заявки на регистрацию';
						case 'eng': return 'Requests on register';
					}
				}
				case 'role': {
					switch ($lang) {
						case 'rus': return 'Роль';
						case 'eng': return 'Role';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ S ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'save': {
					switch ($lang) {
						case 'rus': return 'Сохранить';
						case 'eng': return 'Save';
					}
				}
				case 'send report': {
					switch ($lang) {
						case 'rus': return 'Отправить отчет';
						case 'eng': return 'Send report';
					}
				}
				case 'send request': {
					switch ($lang) {
						case 'rus': return 'Отправить запрос';
						case 'eng': return 'Send request';
					}
				}
				case 'sended reports': {
					switch ($lang) {
						case 'rus': return 'Отправленные отчеты';
						case 'eng': return 'Sended reports';
					}
				}
				case 'sorry': {
					switch ($lang) {
						case 'rus': return 'Извините';
						case 'eng': return 'Sorry';
					}
				}
				case 'staff management': {
					switch ($lang) {
						case 'rus': return 'Управление штатом';
						case 'eng': return 'Staff management';
					}
				}
				case 'start to insert name': {
					switch ($lang) {
						case 'rus': return 'Начните вводить имя';
						case 'eng': return 'Start to insert name';
					}
				}
				case 'surname': {
					switch ($lang) {
						case 'rus': return 'Фамилия';
						case 'eng': return 'Surname';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ T ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'telephone': {
					switch ($lang) {
						case 'rus': return 'Телефон';
						case 'eng': return 'Telephone';
					}
				}
				case 'text': {
					switch ($lang) {
						case 'rus': return 'Текст';
						case 'eng': return 'Text';
					}
				}
				case 'text block': {
					switch ($lang) {
						case 'rus': return 'Текстовый блок';
						case 'eng': return 'Text block';
					}
				}
				case 'text adding': {
					switch ($lang) {
						case 'rus': return 'Добавление текста';
						case 'eng': return 'Text adding';
					}
				}
				case 'text editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование текста';
						case 'eng': return 'Text editing';
					}
				}
				case 'text block is deleted': {
					switch ($lang) {
						case 'rus': return 'Текстовый блок удален';
						case 'eng': return 'Text block is deleted';
					}
				}
				case 'text block is successfully added': {
					switch ($lang) {
						case 'rus': return 'Текстовый блок успешно добавлен';
						case 'eng': return 'Text block is successfully added';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ U ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'upload image': {
					switch ($lang) {
						case 'rus': return 'Загрузить изображение';
						case 'eng': return 'Upload image';
					}
				}
				case 'user block': {
					switch ($lang) {
						case 'rus': return 'Блок пользователя';
						case 'eng': return 'User block';
					}
				}
				case 'user block adding': {
					switch ($lang) {
						case 'rus': return 'Добавление блока пользователя';
						case 'eng': return 'Adding user block';
					}
				}
				case 'user block editing': {
					switch ($lang) {
						case 'rus': return 'Редактирование блока';
						case 'eng': return 'User block editing';
					}
				}
				case 'user block is deleted': {
					switch ($lang) {
						case 'rus': return 'Блок пользователя удален';
						case 'eng': return 'User block is deleted';
					}
				}
				case 'user block is successfully added': {
					switch ($lang) {
						case 'rus': return 'Блок пользователя успешно добавлен';
						case 'eng': return 'User block is successfully added';
					}
				}
				case 'user is deleted': {
					switch ($lang) {
						case 'rus': return 'Пользователь удален';
						case 'eng': return 'User is deleted';
					}
				}
				case 'user was not changed': {
					switch ($lang) {
						case 'rus': return 'Пользователь не был изменен';
						case 'eng': return 'User was not changed';
					}
				}
				case 'user with such login already exists': {
					switch ($lang) {
						case 'rus': return 'Пользователь с таким логином уже существует';
						case 'eng': return 'User with such login already exists';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ V ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ W ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'welcome': {
					switch ($lang) {
						case 'rus': return 'Добро пожаловать';
						case 'eng': return 'Welcome';						
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ X ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Y ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

				case 'yes': {
					switch ($lang) {
						case 'rus': return 'Да';
						case 'eng': return 'Yes';
					}
				}
				case 'your email': {
					switch ($lang) {
						case 'rus': return 'Ваш адрес электронной почты';
						case 'eng': return 'Your email';
					}
				}
				case 'your fathername': {
					switch ($lang) {
						case 'rus': return 'Ваше отчество';
						case 'eng': return 'Your fathername';
					}
				}
				case 'you logout': {
					switch ($lang) {
						case 'rus': return 'Вы вышли';
						case 'eng': return 'You logout';
					}
				}
				case 'your login': {
					switch ($lang) {
						case 'rus': return 'Ваш логин';
						case 'eng': return 'Your login';
					}
				}
				case 'your name': {
					switch ($lang) {
						case 'rus': return 'Ваше имя';
						case 'eng': return 'Your name';
					}
				}
				case 'your phone': {
					switch ($lang) {
						case 'rus': return 'Ваш телефон';
						case 'eng': return 'Your phone';
					}
				}
				case 'your surname': {
					switch ($lang) {
						case 'rus': return 'Ваша фамилия';
						case 'eng': return 'Your surname';
					}
				}

				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Z ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ end_line
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
						case 'eng': return 'Developer';
						default: return 'incorrect language';
					}
				}
				case 40: {
					switch ($lang) {
						case 'rus': return 'Старший программист';
						case 'eng': return 'Senior developer';
						default: return 'incorrect language';
					}
				}
				case 50: {
					switch ($lang) {
						case 'rus': return 'Ведущий программист';
						case 'eng': return 'Lead developer';
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
		    	'тья' => 'tia',
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

		function GetContentTypes($lang = 0) {
			if ($lang === 0) $lang = GetLanguage();
			global $content_types_full;
			$content_types_full = array(
				'articles' => Language::PublicMenu('articles', $lang),
				'directions' => Language::PublicMenu('directions', $lang),
				'projects' => Language::PublicMenu('projects', $lang),
				'about_us' => Language::PublicMenu('about_us', $lang),
			);
			return $content_types_full;
		}

		function Address($lang = 0) {
			if ($lang === 0) $lang = GetLanguage();
			switch ($lang) {
				case 'rus': return '119991 ГСП-1 Москва, Ленинские горы, МГУ имени М.В. Ломоносова, 2-й учебный корпус, факультет ВМК, этаж 5, аудитория 528<br><br>Телефон: 8-495-930-52-87';
				case 'eng': return '119991 GSP-1 Moscow, Leninskie Gory, Lomonosov MSU, 2nd educational building, CMC faculty, 5-th floor, audience 528<br><br>Telephone: 8-495-930-52-87';				
				default: return 'incorrect language';
			}
		}
	}
?>