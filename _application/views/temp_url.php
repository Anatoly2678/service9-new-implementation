        <link href="../../_css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../_css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <link href="../../_css/requestlist.css" rel="stylesheet" type="text/css"/>
<!--<div ng-app="PageApp" ng-controller="WhyUs">
  <p ng-show="loading">Loading...</p>
  <p ng-hide="loading">Response: {{img}}</p>
  <div class="col-xs-12 col-md-6 why wow bounceIn" data-wow-delay="0.1s" ng-repeat="SingleWhy in why">
						<img src="{{SingleWhy.img}}" alt=""><p><span>{{SingleWhy.head}}</span><br>{{SingleWhy.body}}</p>
					</div>
</div>-->

<!--<div ng-app ng-controller="MainCtrl">
  <p ng-show="loading">Loading...</p>
  <p ng-hide="loading">Response: {{response}}</p>
</div>-->
    <div class="requestlist container">
          <div class="panel panel-default requestlist-body">
<div ng-app="PageApp" ng-controller="SecondCtrl as second">
    <table border="1" class="table-request-list">
         <tbody>
              <tr ng-repeat="track in second.tracks">
                    <td>{{track.ReqNo}}</td>
                    <td>{{track.DateRequest}}</td>
                    <td>{{track.TimeRequest}}</td>
                    <td>{{track.ShotTextRequest}}</td>
                    <td>{{track.FavoriteFlag}}</td>
              </tr>
         </tbody>
     </table>
</div>
      </div>
    </div>

 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js"></script>
    <script src="/_js/angular/temp_controller.js"></script>
    <script src="../../_js/bootstrap.min.js" type="text/javascript"></script>
    <!--<script src="../../_js/application/invoice.js" type="text/javascript"></script>-->
