<script type="text/javascript" src="/_js/application/grid-admins.js"></script>
<script type="text/javascript" src="/_js/application/grid-usersactive.js"></script>
<script type="text/javascript" src="/_js/application/grid-usersall.js"></script>


<ul class="nav nav-tabs" style="color:white">
  <li><a href="#admins" data-toggle="tab">Администраторы</a></li>
  <li class="active"><a href="#activeusers" data-toggle="tab">Пользователи активные</a></li>
  <li><a href="#allusers" data-toggle="tab">Пользователи ВСЕ</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane" id="admins">
    	<div id="jqxgrid_admins" class="service9-opacity"></div>
    	<div style='overflow: hidden; position: relative; margin: 5px; color:white'>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-success' disabled='disabled'>Добавить</button>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-success' disabled='disabled'>Редактировать</button>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-danger' disabled='disabled'>Удалить</button>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-warning' disabled='disabled'>Обновить</button>
		</div>
  	</div>
  	<div class="tab-pane active" id="activeusers">
    	<div id="jqxgrid_users_activ" class="service9-opacity" style="height:auto"></div>
    	<div style='overflow: hidden; position: relative; margin: 5px; color:white'>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-success' disabled='disabled'>Добавить</button>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-success' disabled='disabled'>Редактировать</button>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-danger' disabled='disabled'>Удалить</button>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-warning' disabled='disabled'>Найти похожее</button>
		</div>
  	</div>
  	<div class="tab-pane" id="allusers">
		<div id="jqxgrid_users_all" class="service9-opacity" style="height:auto"></div>
		<div style='overflow: hidden; position: relative; margin: 5px; color:white'>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-success' disabled='disabled'>Добавить</button>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-success' disabled='disabled'>Редактировать</button>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-danger' disabled='disabled'>Удалить</button>
			<button style='float: left; margin-left: 5px;' type='button' class='btn btn-warning' disabled='disabled'>Найти похожее</button>
		</div>
  	</div>
</div>