<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="utf-8" http-equiv="encoding">
    <title>White Girl Rankings</title>
    {{ HTML::style('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'); }}
    {{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'); }}
</head>
<body>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-26898313-3', 'auto');
  ga('send', 'pageview');

</script>
<div class="container" style="margin-top:20px;">
	<h1>Rankings</h1>
	<table class="table table-striped table-bordered">
		<thead>
        <tr>
          <th>Name</th>
          <th>Points</th>
        </tr>
      </thead>
	@foreach ($scores as $key => $val)
	<tr>
    	<td>{{$key}}</td>
    	<td>{{$val}}</td>
	</tr>
	@endforeach
	</table>
	<h1>Breakdown</h1>
	<table class="table table-striped table-bordered">
		<thead>
        <tr>
          <th>Offender</th>
          <th>Reason</th>
          <th>Reported by</th>
          <th>Date</th>
        </tr>
      </thead>
	@foreach ($data as $each)
	<tr>
    	<td>{{$each['offender']}}</td>
    	<td>{{$each['reason']}}</td>
    	<td>{{$each['reporter']}}</td>
    	<td>{{$each['created_at']}}</td>
	</tr>
	@endforeach
	</table>


</div>
</body>
</html>