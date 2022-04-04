<?php

	//o contexto onde o require foi recuperado muda pois ele foi acessado por tarefa_controller.php da pasta publica
	require "../../app_lista_tarefas/tarefa.model.php";
	require "../../app_lista_tarefas/tarefa.service.php";
	require "../../app_lista_tarefas/conexao.php";


	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

	//echo $acao;

	if($acao == 'inserir'){

		$tarefa = new Tarefa();
		//setando o valor recebido via post
		$tarefa->__set('tarefa', $_POST['tarefa']);

		//criando uma instância de conexão
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);

		$tarefaService->inserir();

		header('Location: nova_tarefa.php?inclusao=1');
	} else if ($acao == 'recuperar'){
		//fazemos instância de tarefa també pois necessitamos atender a necessidade do construtor
		$tarefa = new Tarefa();
		$conexao = new Conexao();
		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->recuperar();


	}else if($acao == 'atualizar'){

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_POST['id']);
		$tarefa->__set('tarefa', $_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);

		//retorna 1 se tudo ocorreu bem...
		if($tarefaService->atualizar()){
			if (isset($_GET['pag']) && $_GET['pag'] == 'index'){
				header('location: index.php');
			}else{
				header('Location: todas_tarefas.php');
			}
		}
	}else if( $acao == 'remover'){
		
		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id']);

		$conexao = new Conexao();
		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->remover();
		if (isset($_GET['pag']) && $_GET['pag'] == 'index'){
			header('location: index.php');
		}else{
			header('Location: todas_tarefas.php');
		}


	} else if($acao == 'marcarRealizada'){
		$tarefa = new Tarefa();
		$tarefa-> __set('id', $_GET['id']);
		$tarefa-> __set('id_status', 2);

		$conexao = new Conexao();
		$tarefaService = new TarefaService($conexao, $tarefa);

		$tarefaService->marcarRealizada();

		if (isset($_GET['pag']) && $_GET['pag'] == 'index'){
			header('location: index.php');
		}else{
			header('Location: todas_tarefas.php');
		}

	}else if ($acao == 'recuperarTarefasPendentes') {
		$tarefa = new Tarefa();
		$tarefa->__set('id_status', 1);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->recuperarTarefasPendentes();
	}

?>