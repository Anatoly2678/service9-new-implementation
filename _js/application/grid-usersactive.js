 $(document).ready(function () {
 var source =
            {
                datatype: "json",
                datafields: [
                { name: 'id', type: 'string' },
                { name: 'CompanyName', type: 'string' },
                { name: 'user_name', type: 'string' },
                { name: 'Phone', type: 'string' },
                { name: 'Email', type: 'string' },
                { name: 'user_ip', type: 'string' },
                { name: 'user_login', type: 'string' },
                { name: 'user_password', type: 'string' },
                { name: 'user_disabled', type: 'string' },
                { name: 'user_admin', type: 'bool' },
                { name: 'user_datareg', type: 'date' },
                { name: 'user_datapo', type: 'date' },
                { name: 'type', type: 'string' },
                { name: 'tarif', type: 'string' }
                ],
                url: '/_application/json/UsersList.php?usertype=active',
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            $("#jqxgrid_users_activ").jqxGrid(
            {
                width: '100%',
                height: '85%',
                source: dataAdapter,
                columnsresize: false,
                localization: getLocalization('ru'),
                sortable: true,
                filterable: true,
                showfilterrow: true,
                groupable: true,
                columns: [
                    { text: 'ИД', datafield: 'id', align: 'center', cellsalign: 'center', width:'5%'},
                    { text: 'Компания', datafield: 'CompanyName', width:'15%'},
                    { text: 'Контакт', datafield: 'user_name', width:'15%'},
                    { text: 'Телефон', datafield: 'Phone', width:'10%'},
                    { text: 'E-Mail', datafield: 'Email', width:'10%'},
                    { text: 'IP', datafield: 'user_ip', width:'15%'},
                    { text: 'Логин (№ л/к)', datafield: 'user_login', width:'10%'},
                    { text: 'Пароль', datafield: 'user_password', width:'10%'},
                    { text: 'Регистрация', datafield: 'user_datareg', cellsformat: 'd', width:'7%'},
                    { text: 'Период', datafield: 'user_datapo', cellsformat: 'd', width:'7%'},
                    { text: 'Тип', datafield: 'type', width:'15%'},
                    { text: 'Тариф', datafield: 'tarif', width:'20%'},
                ]
            });
            $("#jqxgrid_users_activ").jqxGrid('autoresizecolumns');
   })


