<!DOCTYPE html>
<html lang="en">
  <head>
    <link href="../../_css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../_css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
    <link href="../../_css/invoice.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <div class="invoice container">
      <div class="panel panel-default invoice-body">
        <div class="panel-heading">
          <h3 class="panel-title">Форма оплаты:</h3>
        </div>
        <div class="panel-body" id="invoice-tab">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#step1" data-toggle="tab" step="1"> Шаг 1</a></li>
        <li><a href="#step2" data-toggle="tab" step="2">Шаг 2</a></li>
        <li><a href="#step3" data-toggle="tab" step="3">Шаг 3</a></li>
        <li><a href="#step4" data-toggle="tab" step="4">Шаг 4</a></li>
        <li><a href="#step5" data-toggle="tab" step="5">Шаг 5</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="step1"> 
            <div class="row">
                <div class="input-group">
                    <div class="form-group col-xs-3">
                        <div class="input-group invoice-validate">
                            <span class="input-group-addon glyphicon glyphicon-user" style="top: 0px;"></span>
                            <input type="text" id="numLK" class="form-control" placeholder="№ личного кабинета">
                        </div>
                    </div>
                </div>
                <?php echo($data[0]); ?>
                <div class="col-xs-6"></div>
                <div class="form-group col-xs-4">
                    <input type="text" class="form-control right-radius left-radius result" id="invoice_summ" placeholder="ИТОГО" value="0" disabled="disabled">
                </div> 
                <div class="col-xs-2"></div>
            </div>        
        </div>  
        <div class="tab-pane fade " id="step2">
            <div class="input-group">
                <div class="form-group col-xs-3 col-sm-2">
                    <label class="form-control control-label1">Оплату производит</label>
                </div>
                <div class="form-group col-xs-9 col-sm-7">
                    <div class="input-group">
                        <span class="input-group-addon right-radius">
                            <input type="radio" name="whoPay" value="individual">
                        </span>
                        <label class="form-control control-label1">Физическое лицо</label>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon right-radius">
                            <input type="radio" name="whoPay" value="legalEntity">
                        </span>
                        <label class="form-control control-label1">Юридическое лицо</label>
                    </div>
                </div>
            </div>
            
            <div class="input-group">
                <div class="form-group col-xs-3 col-sm-2">
                    <label class="form-control control-label1">Способы оплаты</label>
                </div>
                <div class="form-group col-xs-9 col-sm-7">
                    <div class="input-group">
                        <span class="input-group-addon right-radius">
                            <input type="radio" name="methodPay" value="invoice">
                        </span>
                        <label class="form-control control-label1">Выписать счет
                            <span style="font-size: 75%; color: gray; position: absolute; top: 22px; left: 10px;">
                                (Оплата через Банк по реквизитам)
                            </span>
                        </label>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon right-radius">
                            <input type="radio" name="methodPay" value="platron">
                        </span>
                        <label class="form-control control-label1">Платрон</label>
                    </div>
                </div>
            </div>            
        </div>
        
        <div class="tab-pane fade" id="step3">
            <div class="panel panel-default" style="color: black">
                <div class="panel-body" id="aferta">
                    <?php include '\_application\include\aferta.php'; ?>
                </div>
                <div id="noAferta" class="panel-body" style="display: none">
                    Экран слишком маленький, посмотрите в PDF
                </div>
                <div class="panel-footer">
                    <div class="input-group col-xs-12">
                        <div class="form-group col-xs-5">
                            <a href="/oferta.pdf" target="_blank" style="color: black; text-decoration: underline">в формате PDF</a>
                        </div>
                        <div class="form-group col-xs-3"></div>
                        <div class="form-group col-xs-4" style="text-align: right; display: none">
                            <a href="#" target="_blank" style="color: black; text-decoration: underline">Редактировать</a>
                        </div>
                    </div>
                    <!--<br />-->
                    <div class="input-group afertaLine">
                        <div class="form-group col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox">
                                </span>
                                <fieldset disabled="">
                                    <input type="text" style="color: red;   " id="disabledTextInput" class="form-control" value="Я полностью и безоговорочно согласен и принимаю все условия данного договора-оферты" title="Я полностью и безоговорочно согласен и принимаю все условия данного договора-оферты">
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="step4">
            <?php echo($data[1]); echo($data[2]);?>
        </div>
        
        <div class="tab-pane fade" id="step5">
            <div class="btn-group-vertical">
                <div class="input-group form-group">
                    <span class="input-group-addon glyphicon glyphicon-book"></span>
                    <div class="btn-group1">
                        <button type="button" class="btn btn-success btn-sm col-xs-6">Распечатать</button>
                    </div>
                </div>               

                <div class="input-group form-group">
                    <span class="input-group-addon glyphicon glyphicon-paperclip"></span>
                    <div class="btn-group1">
                        <button type="button" class="btn btn-success btn-sm col-xs-6">Загрузить в формате PDF</button>
                    </div>
                </div>               

                <div class="input-group form-group">
                    <span class="input-group-addon glyphicon glyphicon-globe"></span>
                    <div class="btn-group1">
                        <button type="button" class="btn btn-success btn-sm col-xs-6">Отправить по электронной почте</button>
                    </div>
                </div>               
            </div>
        </div>
    </div>
    
    <!--Navigation-->
    <div class="input-group col-xs-12">
        <ul class="pager">
            <li><a href="#" id="prevPage">Предыдущая</a></li>
            <li><a href="#" id="nextPage">Следующая</a></li>
        </ul>
    </div>
    
    <!-- Модальное окно, вывод ошибки, для шага 1 -->
    <div class="modal fade" id="modalErrorStep1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Ошибка перехода</h4>
                </div>
                <div class="modal-body">
                    Необходимо выбрать хотя бы один из пунктов оплаты
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

        <!-- Модальное окно, вывод ошибки, для шага 2 -->
    <div class="modal fade" id="modalErrorStep2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Ошибка перехода</h4>
                </div>
                <div class="modal-body">
                    Необходимо указать:
                    <ul>
                        <li>Кто производит оплату</li>
                        <li>Способ оплаты</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
        
        </div>
      </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!--<script src="../../dist/js/bootstrap.min.js"></script>-->
    <script src="../../_js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../_js/application/invoice.js" type="text/javascript"></script>
    <!--<script src="../../assets/js/docs.min.js"></script>-->
    </body>
</html>
