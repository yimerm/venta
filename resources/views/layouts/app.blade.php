 <!DOCTYPE html>
<html>
<head>
	<title>XIMER - @yield('title')</title>
	<link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
	<!--<link rel="stylesheet" href="{{asset('css/app.css')}}">-->
</head>
<body>
	<div id="app">
		<appcomponen-component></appcomponen-component>
		<!--<sidebar-component></sidebar-component>
		<div class="container-fluid">
			<router-view></router-view>
		</div>--> 
 	</div>
	<script src="{{ asset(mix('js/app.js')) }}"></script>
 	<!--<script src="{{asset('js/app.js')}}"></script>-->
</body>
</html>

