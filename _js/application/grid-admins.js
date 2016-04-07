 $(document).ready(function () {
 var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'user_name', type: 'string' },
                    { name: 'user_login', type: 'string' },
                    { name: 'user_disabled', type: 'bool' },
                    { name: 'user_datareg', type: 'date' },
                ],
                url: '/_application/json/UsersList.php?usertype=admin',
            };
     var dataAdapter = new $.jqx.dataAdapter(source);
            $("#jqxgrid_admins").jqxGrid(
            {
                width: '100%',
                height: '85%',
                source: dataAdapter,
                columnsresize: false,
                localization: getLocalization('ru'),
                sortable: true,
                filterable: true,
                showfilterrow: true,
                columns: [
                    { text: 'Имя', datafield: 'user_name', width: '30%', align: 'center', cellsalign: 'center', filtertype: 'input' },
                    { text: 'Логин', datafield: 'user_login', width: '30%', align: 'center', cellsalign: 'center', filtertype: 'input' },
                    { text: 'Отключен', datafield: 'user_disabled', width: '10%',columntype: 'checkbox', align: 'center', cellsalign: 'center', filtertype: 'bool' },
                    { text: 'Дата регистрации', datafield: 'user_datareg', width: '30%', cellsformat: 'd', align: 'center', cellsalign: 'center', filtertype: 'range' },
                    // { text: 'Админ', datafield: 'user_admin', width: '10%',columntype: 'checkbox', align: 'center', cellsalign: 'center',filter: firstNameColumnFilter, hidden: true },
                ]
            });
   })


// 