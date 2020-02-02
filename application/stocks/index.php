<?php
function pr($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

function getStockData(){
    function requestStockJson($page=1)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "X-Requested-With: XMLHttpRequest",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36",
            ),
            CURLOPT_URL => 'https://ph.investing.com/stock-screener/Service/SearchStocks',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => 'country%5B%5D=45&sector=7%2C5%2C12%2C3%2C8%2C9%2C1%2C6%2C2%2C4%2C10%2C11&industry=81%2C56%2C59%2C41%2C68%2C67%2C88%2C51%2C72%2C47%2C12%2C8%2C50%2C2%2C71%2C9%2C69%2C45%2C46%2C13%2C94%2C102%2C95%2C58%2C100%2C101%2C87%2C31%2C6%2C38%2C79%2C30%2C77%2C28%2C5%2C60%2C18%2C26%2C44%2C35%2C53%2C48%2C49%2C55%2C78%2C7%2C86%2C10%2C1%2C34%2C3%2C11%2C62%2C16%2C24%2C20%2C54%2C33%2C83%2C29%2C76%2C37%2C90%2C85%2C82%2C22%2C14%2C17%2C19%2C43%2C89%2C96%2C57%2C84%2C93%2C27%2C74%2C97%2C4%2C73%2C36%2C42%2C98%2C65%2C70%2C40%2C99%2C39%2C92%2C75%2C66%2C63%2C21%2C25%2C64%2C61%2C32%2C91%2C52%2C23%2C15%2C80&equityType=ORD%2CDRC%2CPreferred%2CUnit%2CClosedEnd%2CREIT%2CELKS%2COpenEnd%2CRight%2CParticipationShare%2CCapitalSecurity%2CPerpetualCapitalSecurity%2CGuaranteeCertificate%2CIGC%2CWarrant%2CSeniorNote%2CDebenture%2CETF%2CADR%2CETC%2CETN&pn='.$page.'&order%5Bcol%5D=viewData.symbol&order%5Bdir%5D=a',
        ]);

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }
    function filterData($data){
        $output = [];

        foreach($data as $datum){
            if(!isset($datum->tech_sum_86400)) continue;
            if(strpos($datum->tech_sum_86400, 'buy') !== false){
                array_push($output, $datum);
            }
        }

        return $output;
    }

    $output = [];

    $stockData = json_decode(requestStockJson());

    $totalCount = $stockData->totalCount;
    $output = $stockData->hits;

    for($i=2; count($output)!=$totalCount; $i++){
        $output = array_merge($output, json_decode(requestStockJson($i))->hits);
	}

    return filterData($output);
}
function getTextColor($text){
    $isbold = strpos($text, 'Strong') !== false;

    if(strpos($text, 'Buy') !== false) return ($isbold?'font-weight-bold ':'').'text-success';
    if(strpos($text, 'Sell') !== false) return ($isbold?'font-weight-bold ':'').'text-danger';
    return '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="This is for stocks management">
	<meta name="author" content="Christian Toledana">
	<meta name="theme-color" content="#563d7c">
	<title>Stocks Management</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

	<script src="js/index.js" crossorigin="anonymous"></script>

	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>
</head>
<body>
<header>
	<div class="bg-dark collapse" id="navbarHeader" style="">
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-md-7 py-4">
					<h4 class="text-white">About</h4>
					<p class="text-muted">Add some information about the album below, the author, or any other
						background context. Make it a few sentences long so folks can pick up some informative tidbits.
						Then, link them off to some social networking sites or contact information.</p>
				</div>
				<div class="col-sm-4 offset-md-1 py-4">
					<h4 class="text-white">Contact</h4>
					<ul class="list-unstyled">
						<li><a href="https://getbootstrap.com/docs/4.4/examples/album/#" class="text-white">Follow on
							Twitter</a></li>
						<li><a href="https://getbootstrap.com/docs/4.4/examples/album/#" class="text-white">Like on
							Facebook</a></li>
						<li><a href="https://getbootstrap.com/docs/4.4/examples/album/#" class="text-white">Email me</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="navbar navbar-dark bg-dark shadow-sm">
		<div class="container d-flex justify-content-between">
			<a href="https://getbootstrap.com/docs/4.4/examples/album/#" class="navbar-brand d-flex align-items-center">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
					 stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2"
					 viewBox="0 0 24 24" focusable="false">
					<path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
					<circle cx="12" cy="13" r="4"></circle>
				</svg>
				<strong>Album</strong>
			</a>
			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarHeader"
					aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</div>
	</div>
</header>

<?php

$stockData = getStockData();

?>

<main role="main">
	<div class="album py-5 bg-light">
		<div class="container">
			<div class="my-3 p-3 bg-white rounded shadow-sm">
				<h4 class="border-bottom border-gray pb-2 mb-0">Suggestions</h4>

				<br>

				<table id="example" class="table table-striped table-bordered" style="width:100%">
					<thead>
					<tr>
						<th>Symbol</th>
						<th>Name</th>
						<th>Change</th>
						<th>Volume</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($stockData as $stockDatum) { ?>
					<tr>
						<td><?php echo $stockDatum->stock_symbol; ?></td>
						<td><?php echo $stockDatum->name_trans; ?></td>
						<td class="<?php
                            echo $stockDatum->pair_change_percent==0?
                                '':($stockDatum->pair_change_percent>0?
                                    'text-success':'text-danger');
                        ?>"
                        ><?php echo $stockDatum->pair_change_percent_frmt; ?>%</td>
                        <td><?php echo $stockDatum->turnover_volume_frmt ?></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</main>
</body>
</html>