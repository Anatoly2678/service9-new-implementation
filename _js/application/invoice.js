 $(document).ready(function () {
    var step=5;
    var maxStep=5;
    var sum=0;
    $('#invoice-tab li:eq('+(step-1)+') a').tab('show')
    
    /* Переменные формы */
    var whoPay;
    var methodPay;
    
    /* Щелкаем по ТАБАМ */
    $('#invoice-tab a[data-toggle="tab"').click(function (e) {
        curActiveElem=$(this).closest("ul").find("li.active").find("a").attr("step")
        stepNum=$(this).attr('step');
        if (stepNum>=curActiveElem) {
            res=stepValidation (curActiveElem);
        } else {
            res=true;
        }
        if (!res) {
            return false;
        } else {
            step=parseInt(stepNum);
            /* при переходе на вкладки, проверяем */
            switch(step) {
                case 4:
                    if (whoPay=='individual') {
                        $("#individualAccount").removeClass("invoice-hide");
                        $("#legalEntityAccount").addClass("invoice-hide");
                    }
                    if (whoPay=='legalEntity') {
                        $("#legalEntityAccount").removeClass("invoice-hide");
                        $("#individualAccount").addClass("invoice-hide");
                    }
                    break;
            }
        }
    })

    /* Шагаем назад */
    $('body').on('click', '#prevPage', function(){      
        if (step<=1) return false;
        step=step-1;
        $('#invoice-tab li:eq('+(step-1)+') a').tab('show')
    })
     
    /* Шагаем вперед */
    $('body').on('click', '#nextPage', function(){  
        step=parseInt(step);
        res=stepValidation (step);
        if (!res) return false;
        step=step+1;
        if (step>=maxStep) step=maxStep;
        $('#invoice-tab li:eq('+(step-1)+') a').tab('show')
    })

    /* Валидация ШАГОВ */
    function stepValidation(step) {
        step=parseInt(step)
        res=true;
        switch (step) {
            case 1: /* ШАГ 1 */
                ret=inputValidation_Step1(); 
                    console.log(ret);console.log(sum);
                if (!ret) res=false;
                if (ret && sum<=0) {
                    $('#modalErrorStep1').modal('show');
                    res=false;
                }
                break;
            case 2: /* ШАГ 2 */
                ret=inputValidation_Step2();
                if (!ret) { 
                    $('#modalErrorStep2').modal('show');
                    res=false;
                }
                break;
            case 3: /* ШАГ 3 */
                ret=inputValidation_Step3();
                if (!ret) res=false;
                if (whoPay=='individual') {
                    $("#individualAccount").removeClass("invoice-hide");
                    $("#legalEntityAccount").addClass("invoice-hide");
                }
                if (whoPay=='legalEntity') {
                    $("#legalEntityAccount").removeClass("invoice-hide");
                    $("#individualAccount").addClass("invoice-hide");
                }
                
                break;
            case 4:
                ret=inputValidation_Step4();
                if (!ret) res=false;
                break;
                
            default:
                console.log ("Что то пошло не так и ни туда");
                break;
        }
        return res
    }

    /* Обработчик на чек-бокс Шага 1 */
    $('body').on('click', '.input-group [type="checkbox"]', function(){ 
	mycheckState=$(this).prop('checked');
	switch (mycheckState) {
		case true:
		$(this).closest(".input-group").addClass("has-success has-feedback").removeClass("has-error");
		$(this).closest(".input-group").closest(".form-group").closest(".input-group").find(".inputElem").removeAttr("disabled").focus();
		$(this).closest(".input-group").find("input.form-control").after("<span class='glyphicon glyphicon-ok form-control-feedback'></span>");//.siblings()
                $(this).closest(".input-group").find("span.glyphicon-remove").remove();
		break;
		case false:
		$(this).closest(".input-group").removeClass("has-success has-feedback");
                currElem=$(this).closest(".input-group").closest(".form-group").closest(".input-group").find(".inputElem")
		currElem.attr("disabled","disabled").val(currElem.attr("default"));
		$(this).closest(".input-group").find("input.form-control+ span").remove();
		break;
	}
        price();    
    });

    /* проверяем Все изменения контролов */
    $('body').on('change', '.input-group', function(){ 
        sum=price();
        numLKvalue='';
        numLK=$('#numLK').val();
        if (numLK != '') {
            numLKvalue='Личный кабинет №'+numLK+' / '
        }
        $('.panel-title').html('Форма оплаты: <span>('+numLKvalue+'Итого к оплате '+sum+' руб.)</span>')
    })
    
        /* проверяем Все изменения контролов на ШАГЕ 4 */
    $('body').on('change', '#step4 form:visible input[type="text"]:enabled', function(){
        inputValidation_Step4();
    })

    /* проверка на заполенение текстовые поля для ШАГА 1*/
    function inputValidation_Step1() {
        ret=true;
        $('#step1 input[type="text"]:enabled').each(function(){
            thisValue=$(this).val();
            if (thisValue=='') {
                $(this).closest(".invoice-validate").addClass("has-error has-feedback");
                $(this).closest(".invoice-validate").find('input').after("<span class='glyphicon glyphicon-remove form-control-feedback'></span>");
                ret=false;
            } else {
                $(this).closest(".invoice-validate").removeClass("has-error has-feedback");
                $(this).closest(".invoice-validate").find("input.form-control+ span").remove();
            }
        })
        return ret;
    }

    /* проверка на заполенение ШАГА 2*/
    function inputValidation_Step2() {
        ret=true;
        countElem=2 // Должно быть 2 элемента выбрано
        $('#step2 input[type="radio"]:checked').each(function(){
            whoPay=$('.invoice-body input[type="radio"][name="whoPay"]:checked').val();
            methodPay=$('.invoice-body input[type="radio"][name="methodPay"]:checked').val();
            countElem=countElem-1
        })
        if (countElem>0) ret=false; 
        return ret;
    }

    /* проверка на заполенение ШАГА 3*/
    function inputValidation_Step3() {
        ret=true;
        countElem=1 // Должно быть 2 элемента выбрано
        $('.afertaLine input[type="checkbox"]:checked').each(function(){
            countElem=countElem-1
        })
        if (countElem>0) {
            $('.afertaLine input[type="checkbox"]').closest(".input-group").addClass("has-error has-feedback").removeClass("has-success");
            $('.afertaLine input[type="checkbox"]').closest(".input-group").find("input.form-control").after("<span class='glyphicon glyphicon-remove form-control-feedback'></span>");//.siblings()
            ret=false;
        } 
        return ret;
    }
    
    /* проверка на заполнение ШАГА 4 */
    function inputValidation_Step4() {
        ret=true;
        $('#step4 form:visible input[type="text"]:enabled').not(".novalidate").each(function(){
            thisValue=$(this).val();
            if (thisValue=='') {
                $(this).closest(".invoice-validate").addClass("has-error has-feedback");
                $(this).closest(".invoice-validate").find('input').after("<span class='glyphicon glyphicon-remove form-control-feedback'></span>");
                ret=false;
            } else {
                console.log ($(this))
                console.log ($(this).closest(".invoice-validate"))
                console.log ($(this).closest(".invoice-validate").find("input + span"))
                $(this).closest(".invoice-validate").removeClass("has-error has-feedback");
                $(this).closest(".invoice-validate").find("span.glyphicon-remove").remove();
            }
        })
        return ret;
        
    }
    
    /* считаем суммы */
    function price() {
        sum=0
        $(".invoice-body .inputElem:enabled").each(function(){
            valueElem=$(this).val();
            priceElem=$(this).attr('price');
            if (priceElem===undefined) priceElem=1
            sum=sum+valueElem*priceElem;
        })
        $("#invoice_summ").val(sum);
        return sum;
    }

 })