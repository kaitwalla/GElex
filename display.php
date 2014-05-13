<? $url = 'Enter your web apps URL here';?>
<!doctype html>
<html lang="en">
<head>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,300,700' rel='stylesheet' type='text/css'>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		* {
			font-family:'Open Sans',sans-serif;
		}
		.race {
			width:100%;
			max-width:400px;
			margin-top:5px;
		}

		h3 {
			margin-bottom:3px;
			font-weight:700;
		}

		.pace, td {
			position:relative;
			font-weight:100;
		}

		.progbar {
			z-index:-1;
			position:absolute;
			background:black;
			padding:2px 0;
			display:block;
		}

		td.bar {
			width:30%;
		}
		a.statsBar {
			z-index:-1;
			display:block;
			padding:2px 0;
			width:0px;
		}
		td.results {
			width:30px;
			text-align:right;
		}
		tr.D .statsBar {
			background:#0b00c2;
		}
		tr.R .statsBar {
			background:#bd0000;
		}
		tr.G .statsBar {
			background:#124b02;
		}
		tr.L .statsBar {
        	background:#6100C2;
        }
        tr.I .statsBar {
        	background:#C7C7C7;
        }
        tr.O .statsbar {
        	background:#575757;
        }
	</style>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script>
		var f;
		$(function() {
			$('div.race').each(function() {
				pace = $(this).children('.pace');
				pct = $(pace).attr('data-pct');
				$(pace).children('a').css({height:$(pace).height(),opacity:pct}).animate({width:parseInt($(pace).width()*pct)},'slow','linear');
				if (pct > .49) {
					$(pace).css({color:'white'});
				}
			});
			$('tr.cand').each(function() {
				td = $(this).children('td');
				mTd = td[td.length-1];
				cH = $(mTd).height();
				nW = $(td[0]).width()*(parseInt($(mTd).text())*.01);
				$($(this).children('td')[0]).height(cH);
				$(this).children().children('a.statsBar').css({height:cH}).animate({'width':nW},'slow');
			});
		});
	</script>
</head>
<body>
<?
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$data = json_decode(curl_exec($ch));
curl_close($ch);
foreach ($data->races as $slug => $race) {
	$p = $race->pctCount;
	$pRetty = prettyNum($p);
	$multiball = ($race->pos > 1) ? '<a class="mutiRace"><em>Top '.$race->pos.' advance</em></a>' : false;
	echo '<div class="race"><h3>'.$race->race.'</h3>'.$multiball.'<table class="'.$slug.' race">';
	echo '<div class="pace" data-pct="'.round($p,3).'"><a class="progbar"></a>'.$pRetty.' counted</div>';
	foreach ($race->candidates as $cand) {
			echo '<tr class="cand '.$cand->party.'"><td class="bar"><a class="statsBar"></a></td><td>'.$cand->name.' ('.$cand->party.')'.'</td><td class="results">'.prettyNum($cand->pct).'</td></tr>';
	}
	echo '</table></div>';
}

function prettyNum($num) {
	return (round($num,3)*100).'%';
}
?>
</body>
</html>
