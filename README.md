/**
*
* Esse projeto foi feito inicialmente como um teste para uma vaga de desenvolvedor Laravel/VueJs
*
* Não possuo experiência em VueJS.
*
*/

---------------------------------------------------------------------------------------------------------

Ferramentas utilizadas no frontend - VueJS, VueRouter, VueAxios, JWT-Auth e Bootstrap-vue

Ferramentas utilizadas no backend - Laravel

---------------------------------------------------------------------------------------------------------

Primeiro acesso: para criar um primeiro usuário via linha de comando, abra o terminal, navegue até a pasta "api" ("cd seu_sistema/creative_concept_test/api"), digite "php artisan user:create" e preencha seu nome, e-mail e senha.

---------------------------------------------------------------------------------------------------------

Esse é um sistema simples com login, CRUD de usuários e de tarefas.

O frontend é uma SPA em VueJS, e todas as requisições ao banco de dados são feitas via API (Laravel).

Todo acesso à API foi realizado em ambiente local, com a url "http://127.0.0.1:8000".

As rotas do VueRouter são protegidas - somente usuários autenticados podem acessá-las, com exceção da rota de login. Caso haja a tentativa de acesso da rota 'home', por exemplo, por um usuário não autenticado, ele será redirecionado à rota de login.

Caso um usuário tente acessar uma rota inexistente, o mesmo será redirecionado para a rota 'home' (ou 'login', caso este não esteja autenticado).

As rotas da API são protegidas via Middleware utilizando o JWT-Auth.

As views:

	Login:
		Só pode ser acessada por usuários não autenticados.
		
	Home:
		Tela de boas vindas, só pode ser acessada por usuários autenticados.
		
	Index.Users:
		Tela com a relação dos usuários cadastrados.
		Possui um botão para editar e outro para apagar cada registro da lista.
		Ao excluir um usuário, o mesmo será notificado via e-mail.
		Um usuário não pode excluir a si mesmo.
		A partir dessa dela pode se acessar o cadastro de novos usuários.
		Um alerta é mostrado em caso de sucesso ou falha no "delete" de um usuário.
		Só pode ser acessada por usuários autenticados.
		
	Edit.Users:
		Tela para cadastro de novos usuários ou edição de usuários existentes contendo os campos "nome", "e-mail", "senha" e "confirmação de senha".
		Caso seja um cadastro de um novo usuário, todos os campos são obrigatórios.
		Caso seja uma edição, apenas os campos "nome" e "e-mail" são obrigatórios - os campos de senha só serão preenchidos caso o usuário deseje alterar sua senha. 
		A validação dos dados é feita na API, utilizando o Validator do Laravel. 
		O campo e-mail é único na tabela 'users', excluindo o usuário que está sendo editado dessa regra.
		Um alerta é mostrado em caso de sucesso ou falha no "save" ou "update" de um novo usuário.
		Após a criação ou atualização do usuário, um e-mail é enviado para o mesmo.
		Só pode ser acessada por usuários autenticados.
		
	Index.Tasks:
		Tela com a relação das tarefas cadastradas. Possui um botão para editar e outro para apagar cada registro da lista.
		A partir dessa tela pode se acessar o cadastro de novas tarefas.
		Um alerta é mostrado em caso de sucesso ou falha no "delete" de uma tarefa.
		
	Edit.Tasks:
		Tela para cadastro de novas tarefas ou edição de tarefas existentes contendo os campos "nome", "prazo", "responsável" e "situação". 
		Todos os campos são obrigatórios.
		Os campos "responsável" e "situação" utilizam uma chave estrangeira para as tabelas "users" e "TaskStatus", respectivamente.
		Um alerta é mostrado em caso de sucesso ou falha no "save" ou "update" de uma nova tarefa.
		Só pode ser acessada por usuários autenticados.
		
---------------------------------------------------------------------------------------------------------

O banco de dados:

	Existem três tabelas:
	
		-users (padrão do Laravel), contendo 'id', 'name', 'email', 'password';
		
		-TaskStatus (para armazenar as situações de tarefas), contendo 'id_task_status', 'name' e timestamps;
		
		-Task (para armazenar as tarefas), contendo 'id_task', 'id_task_status' (chave estrangeira - TaskStatus), 'name', 'id_user' (chave estrangeira - users), due_date, created_by (chave estrangeira - users) e timestamps;
		
---------------------------------------------------------------------------------------------------------

A API:

	Cada model é tratado em um controller separado:
	
		UserController - funções:
		
			All() -
			
				[GET] "api/users"
				Retorno da lista de usuários cadastrados;
				
			Get($id) -
			
				[GET] "api/users/{id}"
				Retorno de usuário específico (para edit);
				
			Store($request) - 
			
				[POST] "api/users"
				Cria variáveis para posterior inserção no banco e chama um método privado "Save";
				
			Update($request, $id) - 
			
				[PUT] "api/users/{id}"
				Cria variáveis para posterior update no banco e chama um método privado "Save";
				
			Save($name, $email, $password = null, $idUser = null) -
			
				Função privada.
				Recebe parâmetros obrigatórios e opcionais, preenche o modelo User e salva no banco de dados;
				
			Delete($id) -
			
				[DELETE] "api/users/{id}"
				Apaga um usuário do banco de dados. Não apaga o usuário se ele estiver tentando apagar a si mesmo.
				
				
		TaskStatusController - funcões:
			All() -
			
				[GET] "api/task_statuses"
				Retorno da lista de situações de tarefa cadastradas;

		TaskController - funções:
		
			All() -
			
				[GET] "api/tasks"
				Retorno da lista de tarefas cadastradas com as relações "Responsible" (usuário responsável pela execução da tarefa) e "TaskStatus" (situação da tarefa);
				
			Get($id) -
			
				[GET] "api/tasks/{idTask}"
				Retorno de tarefa específica (para edit) com as relações "Responsible" (usuário responsável pela execução da tarefa) e "TaskStatus" (situação da tarefa);
				
			Store($request) - 
			
				[POST] "api/tasks"
				Cria variáveis para posterior inserção no banco e chama um método privado "Save";
				
			Update($request, $idTask) - 
			
				[PUT] "api/tasks/{idTask}"
				Cria variáveis para posterior update no banco e chama um método privado "Save";
				
			Save($name, $dueDate, $idTaskStatus, $idUser, $idCreator = null, $idTask = null) -
			
				Função privada.
				Recebe parâmetros obrigatórios e opcionais, preenche o modelo Task e salva no banco de dados;
				
			Delete($id) -
			
				[DELETE] "api/tasks/{idTask}"
				Apaga uma tarefa do banco de dados.
				
