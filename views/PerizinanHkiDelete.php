<?php

namespace PHPMaker2021\Dermatekno;

// Page object
$PerizinanHkiDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fperizinan_hkidelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fperizinan_hkidelete = currentForm = new ew.Form("fperizinan_hkidelete", "delete");
    loadjs.done("fperizinan_hkidelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.perizinan_hki) ew.vars.tables.perizinan_hki = <?= JsonEncode(GetClientVar("tables", "perizinan_hki")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fperizinan_hkidelete" id="fperizinan_hkidelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="perizinan_hki">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_perizinan_hki_id" class="perizinan_hki_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->no_order->Visible) { // no_order ?>
        <th class="<?= $Page->no_order->headerCellClass() ?>"><span id="elh_perizinan_hki_no_order" class="perizinan_hki_no_order"><?= $Page->no_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><span id="elh_perizinan_hki_idpegawai" class="perizinan_hki_idpegawai"><?= $Page->idpegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_perizinan_hki_idcustomer" class="perizinan_hki_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_terima->Visible) { // tanggal_terima ?>
        <th class="<?= $Page->tanggal_terima->headerCellClass() ?>"><span id="elh_perizinan_hki_tanggal_terima" class="perizinan_hki_tanggal_terima"><?= $Page->tanggal_terima->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
        <th class="<?= $Page->tanggal_submit->headerCellClass() ?>"><span id="elh_perizinan_hki_tanggal_submit" class="perizinan_hki_tanggal_submit"><?= $Page->tanggal_submit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ktp->Visible) { // ktp ?>
        <th class="<?= $Page->ktp->headerCellClass() ?>"><span id="elh_perizinan_hki_ktp" class="perizinan_hki_ktp"><?= $Page->ktp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
        <th class="<?= $Page->npwp->headerCellClass() ?>"><span id="elh_perizinan_hki_npwp" class="perizinan_hki_npwp"><?= $Page->npwp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nib->Visible) { // nib ?>
        <th class="<?= $Page->nib->headerCellClass() ?>"><span id="elh_perizinan_hki_nib" class="perizinan_hki_nib"><?= $Page->nib->caption() ?></span></th>
<?php } ?>
<?php if ($Page->akta_pendirian->Visible) { // akta_pendirian ?>
        <th class="<?= $Page->akta_pendirian->headerCellClass() ?>"><span id="elh_perizinan_hki_akta_pendirian" class="perizinan_hki_akta_pendirian"><?= $Page->akta_pendirian->caption() ?></span></th>
<?php } ?>
<?php if ($Page->surat_umk->Visible) { // surat_umk ?>
        <th class="<?= $Page->surat_umk->headerCellClass() ?>"><span id="elh_perizinan_hki_surat_umk" class="perizinan_hki_surat_umk"><?= $Page->surat_umk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ttd_pemohon->Visible) { // ttd_pemohon ?>
        <th class="<?= $Page->ttd_pemohon->headerCellClass() ?>"><span id="elh_perizinan_hki_ttd_pemohon" class="perizinan_hki_ttd_pemohon"><?= $Page->ttd_pemohon->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_merk->Visible) { // nama_merk ?>
        <th class="<?= $Page->nama_merk->headerCellClass() ?>"><span id="elh_perizinan_hki_nama_merk" class="perizinan_hki_nama_merk"><?= $Page->nama_merk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->label_merk->Visible) { // label_merk ?>
        <th class="<?= $Page->label_merk->headerCellClass() ?>"><span id="elh_perizinan_hki_label_merk" class="perizinan_hki_label_merk"><?= $Page->label_merk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_perizinan_hki_created_at" class="perizinan_hki_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_id" class="perizinan_hki_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->no_order->Visible) { // no_order ?>
        <td <?= $Page->no_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_no_order" class="perizinan_hki_no_order">
<span<?= $Page->no_order->viewAttributes() ?>>
<?= $Page->no_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_idpegawai" class="perizinan_hki_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_idcustomer" class="perizinan_hki_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_terima->Visible) { // tanggal_terima ?>
        <td <?= $Page->tanggal_terima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_tanggal_terima" class="perizinan_hki_tanggal_terima">
<span<?= $Page->tanggal_terima->viewAttributes() ?>>
<?= $Page->tanggal_terima->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
        <td <?= $Page->tanggal_submit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_tanggal_submit" class="perizinan_hki_tanggal_submit">
<span<?= $Page->tanggal_submit->viewAttributes() ?>>
<?= $Page->tanggal_submit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ktp->Visible) { // ktp ?>
        <td <?= $Page->ktp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_ktp" class="perizinan_hki_ktp">
<span<?= $Page->ktp->viewAttributes() ?>>
<?= $Page->ktp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
        <td <?= $Page->npwp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_npwp" class="perizinan_hki_npwp">
<span<?= $Page->npwp->viewAttributes() ?>>
<?= $Page->npwp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nib->Visible) { // nib ?>
        <td <?= $Page->nib->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_nib" class="perizinan_hki_nib">
<span<?= $Page->nib->viewAttributes() ?>>
<?= $Page->nib->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->akta_pendirian->Visible) { // akta_pendirian ?>
        <td <?= $Page->akta_pendirian->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_akta_pendirian" class="perizinan_hki_akta_pendirian">
<span<?= $Page->akta_pendirian->viewAttributes() ?>>
<?= $Page->akta_pendirian->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->surat_umk->Visible) { // surat_umk ?>
        <td <?= $Page->surat_umk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_surat_umk" class="perizinan_hki_surat_umk">
<span<?= $Page->surat_umk->viewAttributes() ?>>
<?= $Page->surat_umk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ttd_pemohon->Visible) { // ttd_pemohon ?>
        <td <?= $Page->ttd_pemohon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_ttd_pemohon" class="perizinan_hki_ttd_pemohon">
<span<?= $Page->ttd_pemohon->viewAttributes() ?>>
<?= $Page->ttd_pemohon->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_merk->Visible) { // nama_merk ?>
        <td <?= $Page->nama_merk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_nama_merk" class="perizinan_hki_nama_merk">
<span<?= $Page->nama_merk->viewAttributes() ?>>
<?= $Page->nama_merk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->label_merk->Visible) { // label_merk ?>
        <td <?= $Page->label_merk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_label_merk" class="perizinan_hki_label_merk">
<span<?= $Page->label_merk->viewAttributes() ?>>
<?= $Page->label_merk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perizinan_hki_created_at" class="perizinan_hki_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
