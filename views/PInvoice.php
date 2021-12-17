<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$PInvoice = &$Page;
?>
<?php

//-- FUNGSI TERBILANG --//
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
//!-- FUNGSI TERBILANG --//

	$idInvoice = $_GET['id'];

	$invoiceDetail = ExecuteRow("SELECT i.id idinvoice, p.nama namapegawai, o.kode kodepo, o.tanggal tanggalpo, i.kode kodeinvoice, i.tglinvoice tanggalinvoice, t.title tempo, date_add(i.tglinvoice, interval t.value DAY) jatuhtempo, c.nama namacustomer, c.alamat alamat, kel.nama kel, kec.nama kec, kab.nama kab, prov.name prov, c.telpon telponcustomer, i.pajak FROM invoice i, pegawai p, `order` o, termpayment t, customer c LEFT JOIN kelurahan kel ON kel.id=c.idkel LEFT JOIN kecamatan kec ON kec.id=c.idkec LEFT JOIN kabupaten kab ON kab.id=c.idkab LEFT JOIN provinsi prov ON prov.id=c.idprov WHERE i.idcustomer = c.id AND p.id = c.idpegawai AND i.idorder = o.id AND t.id = i.idtermpayment AND i.id=".$idInvoice);

	$query = ExecuteQuery("SELECT id.id, id.idinvoice, p.nama, id.jumlahkirim, id.jumlahbonus, id.harga, id.totalnondiskon, id.diskonpayment, id.totaltagihan FROM invoice_detail id, order_detail od, product p WHERE id.idorder_detail = od.id AND od.idproduct = p.id AND id.idinvoice=".$idInvoice);
    $children = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <head>
        <title>INVOICE</title>
        <style>
            * {
                font-size: 11pt;
            }
            h1 {
                font-size: 16pt;
                line-height: 1pt;
            }
            h2 {
                font-size: 14pt;
                line-height: 14pt;
            }
            table {
                text-align: center;
                width: 100%;
            }
            thead {
                display: table-header-group
            }
            tr {
                page-break-inside: avoid
            }
            sup {
                font-size: 8pt;
            }
            table.bordered th, table.bordered td {
                border: 2px solid black;
                border-collapse: collapse;
            }

            .main-header, .main-sidebar, .content-header, .main-footer {
            	display: none;
            }

            .red {
                color: red;
            }
            .section {
                page-break-after: always;
                page-break-inside: avoid;
            }
            .bordered {
                border: 1px solid black;
                border-collapse: collapse;
            }
            .no-border {
                border: none;
            }
            .no-break {
                page-break-inside: avoid;
            }
            .text-center {
                text-align: center;
            }
            .text-left {
                text-align: left;
            }
            .text-right {
                text-align: right;
            }
            .text-top, .text-top td {
                vertical-align: top;
            }
            td.fit-content {
                width: 1%;
                white-space: nowrap;
            }
            .padding-side {
                padding: 0 0.5em;
            }
            .padding-right {
                padding-right: 1em;
            }
            .tanda-tangan {
                padding: 0 2em;
            }
			.blank-row
			{
				height: 10px !important; /* overwrites any other rules */
				background-color: #FFFFFF;
			}
			tr.noBorder td {
			  border: 0;
			}
			
			.no-border-top {
				border-top: 0px;
			}
			
			.no-border-bottom {
				border-bottom: 0px;
			}
			
			.border-right {
				border-right: 1px solid black;
			}
			.border-left {
				border-left: 1px solid black;
			}
			.border-side {
				border-left: 1px solid black;
				border-right: 1px solid black;
			}
			.border-top {
				border-top: 1px solid black;
			}
			.border-bottom {
				border-bottom: 1px solid black;
			}
			.tab{
				padding-left: 50px;
			}
			
			body:not(.sidebar-mini-md) .content-wrapper, body:not(.sidebar-mini-md) .main-footer, body:not(.sidebar-mini-md) .main-header {
				margin-left: 0;
			}

        </style>
		<style type="text/css" media="print">
		@media print { 
			@page { 
				size: auto;   /* auto is the initial value */
				margin: 0; 
			} 
			body { 
				padding-top: 72px; 
				padding-bottom: 72px ; 
			} 
		} 
		</style>
    </head>
    <body>
        
        <br>

		<table class="text-left">
			<tr>
				<td width="30%">
					<table class="text-left">
						<tr>
							<td colspan="2" class="bordered no-border-bottom"><b>CV BEAUTIE SURYA DERMA</b></td>
						</tr>
						<tr>
							<td colspan="2" class="border-side">Deltasari AD 14 Waru</td>
						</tr>
						<tr>
							<td colspan="2" class="border-side">Sidoarjo 61256</td>
						</tr>
						<tr>
							<td colspan="2" class="border-side">Jawa Timur</td>
						</tr>
						<tr class="bordered no-border-top">
							<td>MR</td>
							<td>: <?= $invoiceDetail['namapegawai'] ?></td>
						</tr>
						<tr>
							<td>No. PO</td>
							<td>: <?= $invoiceDetail['kodepo'] ?></td>
						</tr>
						<tr>
							<td>Tgl PO</td>
							<td>: <?= date('d/m/Y', strtotime($invoiceDetail['tanggalpo'])) ?></td>
						</tr>
						<tr>
							<td>No Faktur</td>
							<td>: <?= $invoiceDetail['kodeinvoice'] ?></td>
						</tr>
						<tr>
							<td>Tgl Faktur</td>
							<td>: <?= date('d/m/Y', strtotime($invoiceDetail['tanggalinvoice'])) ?></td>
						</tr>
						<tr>
							<td class="fit-content">Jatuh Tempo</td>
							<td>: <?= date('d/m/Y', strtotime($invoiceDetail['jatuhtempo'])) ?></td>
						</tr>
					</table>
				</td>
				<td>
					&nbsp;
				</td>
				<td class="text-top" width="30%">
					<table class="text-left">
						<tr class="bordered">
							<td colspan="3" class="text-center"><b>Faktur</b></td>
						</tr>
						<tr class="border-side">
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr class="border-side">
							<td class="fit-content">Kepada</td>
							<td class="fit-content">: </td>
							<td><?= $invoiceDetail['namacustomer'] ?></td>
						</tr>
						<tr class="border-side">
							<td>Alamat</td>
							<td>: </td>
							<td>
								<?= $invoiceDetail['alamat'] ?>
								<?php
									if (!empty($invoiceDetail['kel'])) {
										echo "<br>".$invoiceDetail['kel'];
									}
									if (!empty($invoiceDetail['kec'])) {
										echo "<br>".$invoiceDetail['kec'];
									}
									if (!empty($invoiceDetail['kab'])) {
										echo "<br>".$invoiceDetail['kab'];
									}
									if (!empty($invoiceDetail['prov'])) {
										echo "<br>".$invoiceDetail['prov'];
									}
								?>
							</td>
						</tr>
						<tr class="border-side">
							<td>Telp</td>
							<td>: </td>
							<td><?= $invoiceDetail['telponcustomer'] ?></td>
						</tr>
						<tr class="bordered no-border-top">
							<td colspan="3">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<br>
		
		<?php
		$i = 1;
		$subtotal = 0;
		$totaldiskon = 0;
		$pajak = 0;
		$totalakhir = 0;
		?>
        <table class="text-left text-top">
            <tr class="text-center">
                <th class="bordered">No.</td>
                <th class="bordered">Item</td>
                <th class="bordered">Qty</td>
                <th class="bordered">Harga</td>
				<th class="bordered">Total</td>
            </tr>

			<?php
			foreach ($children as $item) {
			?>
			<tr class="text-center">
				<td class="border-side"><?= $i++ ?></td>
				<td class="text-left border-side padding-side"><?= $item['nama'] ?></td>
				<td class="border-side"><?= $item['jumlahkirim']."+".$item['jumlahbonus'] ?></td>
				<td class="text-right border-side">Rp. <?= number_format($item['harga']) ?></td>
				<td class="text-right border-side">Rp. <?= number_format($item['totalnondiskon']) ?></td>
			</tr>
			<?php
			$subtotal += $item['totalnondiskon'];
			$totaldiskon += $item['totalnondiskon'] - $item['totaltagihan'];
			$totalakhir += $item['totaltagihan'];
			}

			$pajak = $subtotal*$invoiceDetail['pajak']/100;
			$totalakhir += $pajak;
			?>
			
			<tr>
				<td class="bordered" colspan="3" rowspan="4">
					<i>Terbilang: <?= terbilang($totalakhir) ?> rupiah.</i>
				</td>
				<td class="text-center bordered">Sub Total</td>
				<td class="text-right bordered">Rp. <?= number_format($subtotal) ?></td>
			</tr>
			<tr>
				<td class="text-center bordered">Diskon</td>
				<td class="text-right bordered">Rp. <?= number_format($totaldiskon) ?></td>
			</tr>
			<tr>
				<td class="text-center bordered">Pajak</td>
				<td class="text-right bordered">Rp. <?= number_format($pajak) ?></td>
			</tr>
			<tr>
				<td class="text-center bordered"><b>Total Tagihan</b></td>
				<td class="text-right bordered"><b>Rp. <?= number_format($totalakhir) ?></b></td>
			</tr>
			
			<tr class="bordered">
				<td colspan="7">
					Notes:
					<br>Jatuh Tempo Faktur <?= $invoiceDetail['tempo'] ?> sejak faktur diterbitkan.
					<br>Rekening CV.BSD di BCA a/n <span style="font-weight: bold;">Suryo Sudibyo - 82 308 77 533</span>
					<br>Mohon bukti transfer dapat di WA ke Nomor 0821 3228 2441
				</td>
			</tr>
			
        </table>
		
		<br>
		<br>
		<br>
        
		<table class="text-center text-top">
			<tr>
				<td width="30%"></td>
				<td></td>
				<td width="30%">
					Surabaya, <?= date('d F Y', strtotime($invoiceDetail['tanggalinvoice'])) ?>
					<br><br><br><br>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>_______________________</td>
			</tr>
		</table>
        
    </body>
</html>


<?= GetDebugMessage() ?>
