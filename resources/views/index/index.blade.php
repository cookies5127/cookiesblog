<!DOCTYPE html>
<html lang="en" ng-app="cms">
<head>
<meta charset="utf-8">
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href="{{ asset('favicon.ico') }}" rel="shortcut icon"/>
<title>@{{title}} - Cookies's Blog</title>
<link href="{{ asset('asset/css/bootstrap.css') }}" rel="stylesheet"/>
<link href="{{ asset('asset/css/style.css') }}" rel="stylesheet"/>
<link href="{{ asset('asset/css/monokai-sublime.css') }}" rel="stylesheet"/>
<script type="text/javascript" src="/asset/js/jquery.min.js"></script>
<script type="text/javascript" src="/asset/js/bootstrap.js"></script>
</head>
<body ng-controller="MainCtrl">
<div class="container-fluid">

	<div data-ui-view></div>

</div>
<script type="text/javascript" src="/asset/js/angular.js"></script>
<script type="text/javascript" src="/asset/js/angular-ui-router.js"></script>
<script type="text/javascript" src="/asset/js/angular-resource.js"></script>
<script type="text/javascript" src="/asset/js/angular-file-upload.js"></script>
<script type="text/javascript" src="/asset/js/angular-cookies.js"></script>
<script type="text/javascript" src="/asset/js/angular-sanitize.js"></script>
<script type="text/javascript" src="/asset/js/marked.js"></script>
<script type="text/javascript" src="/asset/js/highlight.pack.js"></script>
<script type="text/javascript" src="/asset/js/customer.js"></script>
<script type="text/javascript" src="/asset/angular/app.js"></script>
<script type="text/javascript" src="/asset/angular/ctrl.js"></script>
<script type="text/javascript" src="/asset/angular/filter.js"></script>
<script type="text/javascript" src="/asset/angular/service.js"></script>
<script type="text/javascript" src="/asset/angular/directive.js"></script>

</body>
</html>
