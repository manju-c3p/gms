<div class="bg-gray-50 min-h-screen p-6">

	<!-- Report Header Card -->
	<div class="bg-white shadow-xl rounded-2xl p-6 mb-6 border border-gray-100">

		<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

			<div>
				<h1 class="text-3xl font-bold text-gray-800 tracking-tight">VAT Report</h1>

				<p class="text-sm text-gray-500 mt-1">
					Report Period :
					<span class="font-semibold text-gray-700" id="report_period_text">
						<?php echo isset($from_date) ? date('d-M-Y', strtotime($from_date)) : ''; ?>
						—
						<?php echo isset($to_date) ? date('d-M-Y', strtotime($to_date)) : ''; ?>
					</span>
				</p>
			</div>

			<div class="text-left md:text-right">
				<p class="text-xs uppercase tracking-wide text-gray-400">Generated On</p>
				<p class="text-sm font-semibold text-gray-700">
					<?php
					date_default_timezone_set('Asia/Dubai');
					echo date('d-M-Y h:i A');
					?>
				</p>
			</div>

		</div>

	</div>


	<!-- Filter Card -->
	<div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100">

		<form id="ledger_report_form" method="post" action="<?php echo base_url('index.php/Accounts/tax_report_details'); ?>">

			<div class="grid grid-cols-1 md:grid-cols-6 gap-5 items-end">

				<!-- From Date -->
				<div>
					<label class="block text-sm font-medium text-gray-600 mb-1">From Date</label>
					<input type="date"
						class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
						id="from_date" name="from_date"
						value="<?php echo date('Y-m-d', strtotime($from_date)); ?>" required>
				</div>

				<!-- To Date -->
				<div>
					<label class="block text-sm font-medium text-gray-600 mb-1">To Date</label>
					<input type="date"
						class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
						id="to_date" name="to_date"
						value="<?php echo date('Y-m-d', strtotime($to_date)); ?>" required>
				</div>

				<!-- Report Type -->
				<div>
					<label class="block text-sm font-medium text-gray-600 mb-1">Report Type</label>
					<select name="report_type" id="report_type"
						class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
						required>
						<option value="">Select Type</option>
						<option value="summary">Summary</option>
						<option value="detailed">Detailed</option>
					</select>
				</div>

				<!-- Generate -->
				<div>
					<button type="submit"
						class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold px-2 py-2 rounded-xl shadow transition">
						<i class="fa fa-search mr-1"></i> Generate
					</button>
				</div>

				<!-- Print -->
				<div>
					<button type="button"
						onclick="printReport()"
						class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-2 py-2 rounded-xl shadow transition">
						<i class="fa fa-print mr-1"></i> Print
					</button>
				</div>
				<div>
					<button type="button"
						onclick="exportExcel()"
						class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-2 py-2 rounded-xl shadow transition">
						<i class="fa fa-print mr-1"></i>Excel Export
					</button>
				</div>

			</div>

		</form>

	</div>


	<!-- Report Result -->
	<div id="report_result" class="mt-6"></div>

</div>

<script>
	$(document).ready(function() {
		$('#ledger_report_form').on('submit', function(e) {
			e.preventDefault(); // Prevent page reload

			var formData = $(this).serialize(); // Convert form data to string

			// Show a loading message
			$('#report_result').html('<p class="text-center">Loading report...</p>');

			$.ajax({
				url: $(this).attr('action'), // form action
				type: 'POST',
				data: formData,
				success: function(response) {
					// Replace the report container with returned HTML
					$('#report_result').html(response);
				},
				error: function() {
					$('#report_result').html('<p class="text-danger text-center">Error fetching report.</p>');
				}
			});
		});
	});


	function printReport() {

		var reportContent = document.getElementById('report_result').innerHTML;

		var w = window.open('', '_blank');

		w.document.write(`
				<html>
				<head>
				<title>VAT Report</title>

				<style>

				body{
					font-family: Arial, sans-serif;
					font-size:12px;
					background:#fff;
				}

				.page{
					width:800px;
					margin:0 auto;
				}

				.header{
					display:flex;
					align-items:center;
					justify-content:center;
					gap:20px;
					border-bottom:2px solid #000;
					padding-bottom:10px;
					margin-bottom:15px;
				}

				.logo{
					width:150px;
				}

				.company{
					text-align:center;
					line-height:18px;
				}

				.company b{
					font-size:16px;
				}

				table{
					width:100%;
					border-collapse:collapse;
				}

				th,td{
					border:1px solid #000;
					padding:5px;
				}

				th{
					background:#eee;
				}

				td.text-right{
					text-align:right;
				}

				.footer{
					text-align:center;
					margin-top:40px;
				}

				.footer img{
					width:200px;
					opacity:.9;
				}
					.header{
				display:flex;
				align-items:center;
				justify-content:space-between;
				border-bottom:2px solid #000;
				padding-bottom:10px;
				margin-bottom:15px;
			}

			.company{
				text-align:right;
				line-height:18px;
			}

			.company b{
				font-size:16px;
			}

				@media print{

					@page{
						size:A4;
						margin:20mm;
					}

				}

				</style>

				</head>

				<body>

				<div class="page">

					<div class="header" style="display: flex;
						justify-content: space-between;">
						<img src="<?= base_url('public/images/logocooling.png') ?>" class="logo">

						<div class="company">
							<b>Cool Runnings Garage Co LLC</b><br>
							7 St, Al Quoz 3, Dubai, UAE<br>
							www.coolrunningsgarage.com<br>
							info@coolrunningsgarage.com<br>
							Tel: +971 4 265 4887<br>
							TRN: 104026094300003
						</div>
					</div>

					${reportContent}

					<div class="footer">
						
					</div>

				</div>

				</body>
				</html>
				`);

		w.document.close();

		setTimeout(() => {
			w.print();
		}, 500);

	}

	function exportExcel() {
		var reportDiv = document.getElementById("report_result");


		if (reportDiv.innerHTML.trim() === "") {
			alert("Please generate report first");
			return;
		}

		var content = reportDiv.innerHTML;

		var template = `
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"/>

    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>VAT Report</x:Name>
                    <x:WorksheetOptions>
                        <x:DisplayGridlines/>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->

    <style>
        body{font-family:Arial;font-size:12px;}
        table{border-collapse:collapse;width:100%;margin-bottom:20px;}
        th{background:#d9d9d9;border:1px solid #000;padding:6px;text-align:left;font-weight:bold;}
        td{border:1px solid #000;padding:6px;}
        .text-right{text-align:right;}
        .total{font-weight:bold;background:#f2f2f2;}
    </style>

</head>

<body>

    <h2>VAT Report</h2>
    ${content}

</body>
</html>
`;

		var blob = new Blob([template], {
			type: "application/vnd.ms-excel;charset=utf-8;"
		});

		var link = document.createElement("a");
		document.body.appendChild(link);

		link.href = URL.createObjectURL(blob);
		link.download = "VAT_Report.xls";
		link.click();

		document.body.removeChild(link);


	}


	function exportExcel11() {
		var reportDiv = document.getElementById("report_result");

		if (reportDiv.innerHTML.trim() === "") {
			alert("Please generate report first");
			return;
		}

		var content = reportDiv.innerHTML;

		var excelFile = `
				<html xmlns:o="urn:schemas-microsoft-com:office:office"
				xmlns:x="urn:schemas-microsoft-com:office:excel"
				xmlns="http://www.w3.org/TR/REC-html40">

				<head>
					<meta charset="utf-8">

					<style>
						body{
							font-family: Arial;
							font-size:12px;
						}

						h3{
							margin-top:25px;
							margin-bottom:5px;
						}

						table{
							border-collapse:collapse;
							width:100%;
							margin-bottom:20px;
						}

						th{
							background:#d9d9d9;
							border:1px solid #000;
							padding:6px;
							text-align:left;
							font-weight:bold;
						}

						td{
							border:1px solid #000;
							padding:6px;
						}

						.text-right{
							text-align:right;
						}

						.total{
							font-weight:bold;
							background:#f2f2f2;
						}

					</style>

				</head>

				<body>

					<h2>VAT Report</h2>

					${content}

				</body>
				</html>
				`;

		var blob = new Blob([excelFile], {
			type: "application/vnd.ms-excel"
		});

		var link = document.createElement("a");
		link.href = URL.createObjectURL(blob);
		link.download = "VAT_Report.xls";
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);


	}
</script>

<script id="x3fd8k">
	function formatDateForCaption(dateStr) {
		let d = new Date(dateStr);
		let day = String(d.getDate()).padStart(2, '0');
		let month = d.toLocaleString('en-GB', {
			month: 'short'
		});
		let year = d.getFullYear();
		return day + '-' + month + '-' + year;
	}

	function updateReportCaption() {
		let from = document.getElementById('from_date').value;
		let to = document.getElementById('to_date').value;

		if (from && to) {
			document.getElementById('report_period_text').innerText =
				formatDateForCaption(from) + " — " + formatDateForCaption(to);
		}
	}

	document.getElementById('from_date').addEventListener('change', updateReportCaption);
	document.getElementById('to_date').addEventListener('change', updateReportCaption);
</script>
