<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$NpdTermsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_termslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fnpd_termslist = currentForm = new ew.Form("fnpd_termslist", "list");
    fnpd_termslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fnpd_termslist");
});
var fnpd_termslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fnpd_termslistsrch = currentSearchForm = new ew.Form("fnpd_termslistsrch");

    // Dynamic selection lists

    // Filters
    fnpd_termslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fnpd_termslistsrch");
});
</script>
<style>
.ew-table-preview-row { /* main table preview row color */
    background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
    display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
    <div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
        <ul class="nav nav-tabs"></ul>
        <div class="tab-content"><!-- .tab-content -->
            <div class="tab-pane fade active show"></div>
        </div><!-- /.tab-content -->
    </div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
    ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "right" : "left";
    ew.PREVIEW_SINGLE_ROW = false;
    ew.PREVIEW_OVERLAY = false;
    loadjs(ew.PATH_BASE + "js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fnpd_termslistsrch" id="fnpd_termslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fnpd_termslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="npd_terms">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_terms">
<form name="fnpd_termslist" id="fnpd_termslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_terms">
<div id="gmp_npd_terms" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_npd_termslist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_npd_terms_id" class="npd_terms_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th data-name="idnpd" class="<?= $Page->idnpd->headerCellClass() ?>"><div id="elh_npd_terms_idnpd" class="npd_terms_idnpd"><?= $Page->renderSort($Page->idnpd) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_npd_terms_status" class="npd_terms_status"><?= $Page->renderSort($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <th data-name="tglsubmit" class="<?= $Page->tglsubmit->headerCellClass() ?>"><div id="elh_npd_terms_tglsubmit" class="npd_terms_tglsubmit"><?= $Page->renderSort($Page->tglsubmit) ?></div></th>
<?php } ?>
<?php if ($Page->sifatorder->Visible) { // sifatorder ?>
        <th data-name="sifatorder" class="<?= $Page->sifatorder->headerCellClass() ?>"><div id="elh_npd_terms_sifatorder" class="npd_terms_sifatorder"><?= $Page->renderSort($Page->sifatorder) ?></div></th>
<?php } ?>
<?php if ($Page->ukuranutama->Visible) { // ukuranutama ?>
        <th data-name="ukuranutama" class="<?= $Page->ukuranutama->headerCellClass() ?>"><div id="elh_npd_terms_ukuranutama" class="npd_terms_ukuranutama"><?= $Page->renderSort($Page->ukuranutama) ?></div></th>
<?php } ?>
<?php if ($Page->utamahargaisipcs->Visible) { // utamahargaisipcs ?>
        <th data-name="utamahargaisipcs" class="<?= $Page->utamahargaisipcs->headerCellClass() ?>"><div id="elh_npd_terms_utamahargaisipcs" class="npd_terms_utamahargaisipcs"><?= $Page->renderSort($Page->utamahargaisipcs) ?></div></th>
<?php } ?>
<?php if ($Page->utamahargaprimerpcs->Visible) { // utamahargaprimerpcs ?>
        <th data-name="utamahargaprimerpcs" class="<?= $Page->utamahargaprimerpcs->headerCellClass() ?>"><div id="elh_npd_terms_utamahargaprimerpcs" class="npd_terms_utamahargaprimerpcs"><?= $Page->renderSort($Page->utamahargaprimerpcs) ?></div></th>
<?php } ?>
<?php if ($Page->utamahargasekunderpcs->Visible) { // utamahargasekunderpcs ?>
        <th data-name="utamahargasekunderpcs" class="<?= $Page->utamahargasekunderpcs->headerCellClass() ?>"><div id="elh_npd_terms_utamahargasekunderpcs" class="npd_terms_utamahargasekunderpcs"><?= $Page->renderSort($Page->utamahargasekunderpcs) ?></div></th>
<?php } ?>
<?php if ($Page->utamahargalabelpcs->Visible) { // utamahargalabelpcs ?>
        <th data-name="utamahargalabelpcs" class="<?= $Page->utamahargalabelpcs->headerCellClass() ?>"><div id="elh_npd_terms_utamahargalabelpcs" class="npd_terms_utamahargalabelpcs"><?= $Page->renderSort($Page->utamahargalabelpcs) ?></div></th>
<?php } ?>
<?php if ($Page->utamahargatotalpcs->Visible) { // utamahargatotalpcs ?>
        <th data-name="utamahargatotalpcs" class="<?= $Page->utamahargatotalpcs->headerCellClass() ?>"><div id="elh_npd_terms_utamahargatotalpcs" class="npd_terms_utamahargatotalpcs"><?= $Page->renderSort($Page->utamahargatotalpcs) ?></div></th>
<?php } ?>
<?php if ($Page->utamahargaisiorder->Visible) { // utamahargaisiorder ?>
        <th data-name="utamahargaisiorder" class="<?= $Page->utamahargaisiorder->headerCellClass() ?>"><div id="elh_npd_terms_utamahargaisiorder" class="npd_terms_utamahargaisiorder"><?= $Page->renderSort($Page->utamahargaisiorder) ?></div></th>
<?php } ?>
<?php if ($Page->utamahargaprimerorder->Visible) { // utamahargaprimerorder ?>
        <th data-name="utamahargaprimerorder" class="<?= $Page->utamahargaprimerorder->headerCellClass() ?>"><div id="elh_npd_terms_utamahargaprimerorder" class="npd_terms_utamahargaprimerorder"><?= $Page->renderSort($Page->utamahargaprimerorder) ?></div></th>
<?php } ?>
<?php if ($Page->utamahargasekunderorder->Visible) { // utamahargasekunderorder ?>
        <th data-name="utamahargasekunderorder" class="<?= $Page->utamahargasekunderorder->headerCellClass() ?>"><div id="elh_npd_terms_utamahargasekunderorder" class="npd_terms_utamahargasekunderorder"><?= $Page->renderSort($Page->utamahargasekunderorder) ?></div></th>
<?php } ?>
<?php if ($Page->utamahargalabelorder->Visible) { // utamahargalabelorder ?>
        <th data-name="utamahargalabelorder" class="<?= $Page->utamahargalabelorder->headerCellClass() ?>"><div id="elh_npd_terms_utamahargalabelorder" class="npd_terms_utamahargalabelorder"><?= $Page->renderSort($Page->utamahargalabelorder) ?></div></th>
<?php } ?>
<?php if ($Page->utamahargatotalorder->Visible) { // utamahargatotalorder ?>
        <th data-name="utamahargatotalorder" class="<?= $Page->utamahargatotalorder->headerCellClass() ?>"><div id="elh_npd_terms_utamahargatotalorder" class="npd_terms_utamahargatotalorder"><?= $Page->renderSort($Page->utamahargatotalorder) ?></div></th>
<?php } ?>
<?php if ($Page->ukuranlain->Visible) { // ukuranlain ?>
        <th data-name="ukuranlain" class="<?= $Page->ukuranlain->headerCellClass() ?>"><div id="elh_npd_terms_ukuranlain" class="npd_terms_ukuranlain"><?= $Page->renderSort($Page->ukuranlain) ?></div></th>
<?php } ?>
<?php if ($Page->lainhargaisipcs->Visible) { // lainhargaisipcs ?>
        <th data-name="lainhargaisipcs" class="<?= $Page->lainhargaisipcs->headerCellClass() ?>"><div id="elh_npd_terms_lainhargaisipcs" class="npd_terms_lainhargaisipcs"><?= $Page->renderSort($Page->lainhargaisipcs) ?></div></th>
<?php } ?>
<?php if ($Page->lainhargaprimerpcs->Visible) { // lainhargaprimerpcs ?>
        <th data-name="lainhargaprimerpcs" class="<?= $Page->lainhargaprimerpcs->headerCellClass() ?>"><div id="elh_npd_terms_lainhargaprimerpcs" class="npd_terms_lainhargaprimerpcs"><?= $Page->renderSort($Page->lainhargaprimerpcs) ?></div></th>
<?php } ?>
<?php if ($Page->lainhargasekunderpcs->Visible) { // lainhargasekunderpcs ?>
        <th data-name="lainhargasekunderpcs" class="<?= $Page->lainhargasekunderpcs->headerCellClass() ?>"><div id="elh_npd_terms_lainhargasekunderpcs" class="npd_terms_lainhargasekunderpcs"><?= $Page->renderSort($Page->lainhargasekunderpcs) ?></div></th>
<?php } ?>
<?php if ($Page->lainhargalabelpcs->Visible) { // lainhargalabelpcs ?>
        <th data-name="lainhargalabelpcs" class="<?= $Page->lainhargalabelpcs->headerCellClass() ?>"><div id="elh_npd_terms_lainhargalabelpcs" class="npd_terms_lainhargalabelpcs"><?= $Page->renderSort($Page->lainhargalabelpcs) ?></div></th>
<?php } ?>
<?php if ($Page->lainhargatotalpcs->Visible) { // lainhargatotalpcs ?>
        <th data-name="lainhargatotalpcs" class="<?= $Page->lainhargatotalpcs->headerCellClass() ?>"><div id="elh_npd_terms_lainhargatotalpcs" class="npd_terms_lainhargatotalpcs"><?= $Page->renderSort($Page->lainhargatotalpcs) ?></div></th>
<?php } ?>
<?php if ($Page->lainhargaisiorder->Visible) { // lainhargaisiorder ?>
        <th data-name="lainhargaisiorder" class="<?= $Page->lainhargaisiorder->headerCellClass() ?>"><div id="elh_npd_terms_lainhargaisiorder" class="npd_terms_lainhargaisiorder"><?= $Page->renderSort($Page->lainhargaisiorder) ?></div></th>
<?php } ?>
<?php if ($Page->lainhargaprimerorder->Visible) { // lainhargaprimerorder ?>
        <th data-name="lainhargaprimerorder" class="<?= $Page->lainhargaprimerorder->headerCellClass() ?>"><div id="elh_npd_terms_lainhargaprimerorder" class="npd_terms_lainhargaprimerorder"><?= $Page->renderSort($Page->lainhargaprimerorder) ?></div></th>
<?php } ?>
<?php if ($Page->lainhargasekunderorder->Visible) { // lainhargasekunderorder ?>
        <th data-name="lainhargasekunderorder" class="<?= $Page->lainhargasekunderorder->headerCellClass() ?>"><div id="elh_npd_terms_lainhargasekunderorder" class="npd_terms_lainhargasekunderorder"><?= $Page->renderSort($Page->lainhargasekunderorder) ?></div></th>
<?php } ?>
<?php if ($Page->lainhargalabelorder->Visible) { // lainhargalabelorder ?>
        <th data-name="lainhargalabelorder" class="<?= $Page->lainhargalabelorder->headerCellClass() ?>"><div id="elh_npd_terms_lainhargalabelorder" class="npd_terms_lainhargalabelorder"><?= $Page->renderSort($Page->lainhargalabelorder) ?></div></th>
<?php } ?>
<?php if ($Page->lainhargatotalorder->Visible) { // lainhargatotalorder ?>
        <th data-name="lainhargatotalorder" class="<?= $Page->lainhargatotalorder->headerCellClass() ?>"><div id="elh_npd_terms_lainhargatotalorder" class="npd_terms_lainhargatotalorder"><?= $Page->renderSort($Page->lainhargatotalorder) ?></div></th>
<?php } ?>
<?php if ($Page->isibahanaktif->Visible) { // isibahanaktif ?>
        <th data-name="isibahanaktif" class="<?= $Page->isibahanaktif->headerCellClass() ?>"><div id="elh_npd_terms_isibahanaktif" class="npd_terms_isibahanaktif"><?= $Page->renderSort($Page->isibahanaktif) ?></div></th>
<?php } ?>
<?php if ($Page->isibahanlain->Visible) { // isibahanlain ?>
        <th data-name="isibahanlain" class="<?= $Page->isibahanlain->headerCellClass() ?>"><div id="elh_npd_terms_isibahanlain" class="npd_terms_isibahanlain"><?= $Page->renderSort($Page->isibahanlain) ?></div></th>
<?php } ?>
<?php if ($Page->isiparfum->Visible) { // isiparfum ?>
        <th data-name="isiparfum" class="<?= $Page->isiparfum->headerCellClass() ?>"><div id="elh_npd_terms_isiparfum" class="npd_terms_isiparfum"><?= $Page->renderSort($Page->isiparfum) ?></div></th>
<?php } ?>
<?php if ($Page->isiestetika->Visible) { // isiestetika ?>
        <th data-name="isiestetika" class="<?= $Page->isiestetika->headerCellClass() ?>"><div id="elh_npd_terms_isiestetika" class="npd_terms_isiestetika"><?= $Page->renderSort($Page->isiestetika) ?></div></th>
<?php } ?>
<?php if ($Page->kemasanwadah->Visible) { // kemasanwadah ?>
        <th data-name="kemasanwadah" class="<?= $Page->kemasanwadah->headerCellClass() ?>"><div id="elh_npd_terms_kemasanwadah" class="npd_terms_kemasanwadah"><?= $Page->renderSort($Page->kemasanwadah) ?></div></th>
<?php } ?>
<?php if ($Page->kemasantutup->Visible) { // kemasantutup ?>
        <th data-name="kemasantutup" class="<?= $Page->kemasantutup->headerCellClass() ?>"><div id="elh_npd_terms_kemasantutup" class="npd_terms_kemasantutup"><?= $Page->renderSort($Page->kemasantutup) ?></div></th>
<?php } ?>
<?php if ($Page->kemasansekunder->Visible) { // kemasansekunder ?>
        <th data-name="kemasansekunder" class="<?= $Page->kemasansekunder->headerCellClass() ?>"><div id="elh_npd_terms_kemasansekunder" class="npd_terms_kemasansekunder"><?= $Page->renderSort($Page->kemasansekunder) ?></div></th>
<?php } ?>
<?php if ($Page->desainlabel->Visible) { // desainlabel ?>
        <th data-name="desainlabel" class="<?= $Page->desainlabel->headerCellClass() ?>"><div id="elh_npd_terms_desainlabel" class="npd_terms_desainlabel"><?= $Page->renderSort($Page->desainlabel) ?></div></th>
<?php } ?>
<?php if ($Page->cetaklabel->Visible) { // cetaklabel ?>
        <th data-name="cetaklabel" class="<?= $Page->cetaklabel->headerCellClass() ?>"><div id="elh_npd_terms_cetaklabel" class="npd_terms_cetaklabel"><?= $Page->renderSort($Page->cetaklabel) ?></div></th>
<?php } ?>
<?php if ($Page->lainlain->Visible) { // lainlain ?>
        <th data-name="lainlain" class="<?= $Page->lainlain->headerCellClass() ?>"><div id="elh_npd_terms_lainlain" class="npd_terms_lainlain"><?= $Page->renderSort($Page->lainlain) ?></div></th>
<?php } ?>
<?php if ($Page->deliverypickup->Visible) { // deliverypickup ?>
        <th data-name="deliverypickup" class="<?= $Page->deliverypickup->headerCellClass() ?>"><div id="elh_npd_terms_deliverypickup" class="npd_terms_deliverypickup"><?= $Page->renderSort($Page->deliverypickup) ?></div></th>
<?php } ?>
<?php if ($Page->deliverysinglepoint->Visible) { // deliverysinglepoint ?>
        <th data-name="deliverysinglepoint" class="<?= $Page->deliverysinglepoint->headerCellClass() ?>"><div id="elh_npd_terms_deliverysinglepoint" class="npd_terms_deliverysinglepoint"><?= $Page->renderSort($Page->deliverysinglepoint) ?></div></th>
<?php } ?>
<?php if ($Page->deliverymultipoint->Visible) { // deliverymultipoint ?>
        <th data-name="deliverymultipoint" class="<?= $Page->deliverymultipoint->headerCellClass() ?>"><div id="elh_npd_terms_deliverymultipoint" class="npd_terms_deliverymultipoint"><?= $Page->renderSort($Page->deliverymultipoint) ?></div></th>
<?php } ?>
<?php if ($Page->deliveryjumlahpoint->Visible) { // deliveryjumlahpoint ?>
        <th data-name="deliveryjumlahpoint" class="<?= $Page->deliveryjumlahpoint->headerCellClass() ?>"><div id="elh_npd_terms_deliveryjumlahpoint" class="npd_terms_deliveryjumlahpoint"><?= $Page->renderSort($Page->deliveryjumlahpoint) ?></div></th>
<?php } ?>
<?php if ($Page->deliverytermslain->Visible) { // deliverytermslain ?>
        <th data-name="deliverytermslain" class="<?= $Page->deliverytermslain->headerCellClass() ?>"><div id="elh_npd_terms_deliverytermslain" class="npd_terms_deliverytermslain"><?= $Page->renderSort($Page->deliverytermslain) ?></div></th>
<?php } ?>
<?php if ($Page->catatankhusus->Visible) { // catatankhusus ?>
        <th data-name="catatankhusus" class="<?= $Page->catatankhusus->headerCellClass() ?>"><div id="elh_npd_terms_catatankhusus" class="npd_terms_catatankhusus"><?= $Page->renderSort($Page->catatankhusus) ?></div></th>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <th data-name="dibuatdi" class="<?= $Page->dibuatdi->headerCellClass() ?>"><div id="elh_npd_terms_dibuatdi" class="npd_terms_dibuatdi"><?= $Page->renderSort($Page->dibuatdi) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <th data-name="tanggal" class="<?= $Page->tanggal->headerCellClass() ?>"><div id="elh_npd_terms_tanggal" class="npd_terms_tanggal"><?= $Page->renderSort($Page->tanggal) ?></div></th>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <th data-name="created_by" class="<?= $Page->created_by->headerCellClass() ?>"><div id="elh_npd_terms_created_by" class="npd_terms_created_by"><?= $Page->renderSort($Page->created_by) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_npd_terms", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <td data-name="tglsubmit" <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sifatorder->Visible) { // sifatorder ?>
        <td data-name="sifatorder" <?= $Page->sifatorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_sifatorder">
<span<?= $Page->sifatorder->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_sifatorder_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->sifatorder->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->sifatorder->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_sifatorder_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ukuranutama->Visible) { // ukuranutama ?>
        <td data-name="ukuranutama" <?= $Page->ukuranutama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_ukuranutama">
<span<?= $Page->ukuranutama->viewAttributes() ?>>
<?= $Page->ukuranutama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utamahargaisipcs->Visible) { // utamahargaisipcs ?>
        <td data-name="utamahargaisipcs" <?= $Page->utamahargaisipcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargaisipcs">
<span<?= $Page->utamahargaisipcs->viewAttributes() ?>>
<?= $Page->utamahargaisipcs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utamahargaprimerpcs->Visible) { // utamahargaprimerpcs ?>
        <td data-name="utamahargaprimerpcs" <?= $Page->utamahargaprimerpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargaprimerpcs">
<span<?= $Page->utamahargaprimerpcs->viewAttributes() ?>>
<?= $Page->utamahargaprimerpcs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utamahargasekunderpcs->Visible) { // utamahargasekunderpcs ?>
        <td data-name="utamahargasekunderpcs" <?= $Page->utamahargasekunderpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargasekunderpcs">
<span<?= $Page->utamahargasekunderpcs->viewAttributes() ?>>
<?= $Page->utamahargasekunderpcs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utamahargalabelpcs->Visible) { // utamahargalabelpcs ?>
        <td data-name="utamahargalabelpcs" <?= $Page->utamahargalabelpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargalabelpcs">
<span<?= $Page->utamahargalabelpcs->viewAttributes() ?>>
<?= $Page->utamahargalabelpcs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utamahargatotalpcs->Visible) { // utamahargatotalpcs ?>
        <td data-name="utamahargatotalpcs" <?= $Page->utamahargatotalpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargatotalpcs">
<span<?= $Page->utamahargatotalpcs->viewAttributes() ?>>
<?= $Page->utamahargatotalpcs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utamahargaisiorder->Visible) { // utamahargaisiorder ?>
        <td data-name="utamahargaisiorder" <?= $Page->utamahargaisiorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargaisiorder">
<span<?= $Page->utamahargaisiorder->viewAttributes() ?>>
<?= $Page->utamahargaisiorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utamahargaprimerorder->Visible) { // utamahargaprimerorder ?>
        <td data-name="utamahargaprimerorder" <?= $Page->utamahargaprimerorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargaprimerorder">
<span<?= $Page->utamahargaprimerorder->viewAttributes() ?>>
<?= $Page->utamahargaprimerorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utamahargasekunderorder->Visible) { // utamahargasekunderorder ?>
        <td data-name="utamahargasekunderorder" <?= $Page->utamahargasekunderorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargasekunderorder">
<span<?= $Page->utamahargasekunderorder->viewAttributes() ?>>
<?= $Page->utamahargasekunderorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utamahargalabelorder->Visible) { // utamahargalabelorder ?>
        <td data-name="utamahargalabelorder" <?= $Page->utamahargalabelorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargalabelorder">
<span<?= $Page->utamahargalabelorder->viewAttributes() ?>>
<?= $Page->utamahargalabelorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utamahargatotalorder->Visible) { // utamahargatotalorder ?>
        <td data-name="utamahargatotalorder" <?= $Page->utamahargatotalorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utamahargatotalorder">
<span<?= $Page->utamahargatotalorder->viewAttributes() ?>>
<?= $Page->utamahargatotalorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ukuranlain->Visible) { // ukuranlain ?>
        <td data-name="ukuranlain" <?= $Page->ukuranlain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_ukuranlain">
<span<?= $Page->ukuranlain->viewAttributes() ?>>
<?= $Page->ukuranlain->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainhargaisipcs->Visible) { // lainhargaisipcs ?>
        <td data-name="lainhargaisipcs" <?= $Page->lainhargaisipcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargaisipcs">
<span<?= $Page->lainhargaisipcs->viewAttributes() ?>>
<?= $Page->lainhargaisipcs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainhargaprimerpcs->Visible) { // lainhargaprimerpcs ?>
        <td data-name="lainhargaprimerpcs" <?= $Page->lainhargaprimerpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargaprimerpcs">
<span<?= $Page->lainhargaprimerpcs->viewAttributes() ?>>
<?= $Page->lainhargaprimerpcs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainhargasekunderpcs->Visible) { // lainhargasekunderpcs ?>
        <td data-name="lainhargasekunderpcs" <?= $Page->lainhargasekunderpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargasekunderpcs">
<span<?= $Page->lainhargasekunderpcs->viewAttributes() ?>>
<?= $Page->lainhargasekunderpcs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainhargalabelpcs->Visible) { // lainhargalabelpcs ?>
        <td data-name="lainhargalabelpcs" <?= $Page->lainhargalabelpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargalabelpcs">
<span<?= $Page->lainhargalabelpcs->viewAttributes() ?>>
<?= $Page->lainhargalabelpcs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainhargatotalpcs->Visible) { // lainhargatotalpcs ?>
        <td data-name="lainhargatotalpcs" <?= $Page->lainhargatotalpcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargatotalpcs">
<span<?= $Page->lainhargatotalpcs->viewAttributes() ?>>
<?= $Page->lainhargatotalpcs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainhargaisiorder->Visible) { // lainhargaisiorder ?>
        <td data-name="lainhargaisiorder" <?= $Page->lainhargaisiorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargaisiorder">
<span<?= $Page->lainhargaisiorder->viewAttributes() ?>>
<?= $Page->lainhargaisiorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainhargaprimerorder->Visible) { // lainhargaprimerorder ?>
        <td data-name="lainhargaprimerorder" <?= $Page->lainhargaprimerorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargaprimerorder">
<span<?= $Page->lainhargaprimerorder->viewAttributes() ?>>
<?= $Page->lainhargaprimerorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainhargasekunderorder->Visible) { // lainhargasekunderorder ?>
        <td data-name="lainhargasekunderorder" <?= $Page->lainhargasekunderorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargasekunderorder">
<span<?= $Page->lainhargasekunderorder->viewAttributes() ?>>
<?= $Page->lainhargasekunderorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainhargalabelorder->Visible) { // lainhargalabelorder ?>
        <td data-name="lainhargalabelorder" <?= $Page->lainhargalabelorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargalabelorder">
<span<?= $Page->lainhargalabelorder->viewAttributes() ?>>
<?= $Page->lainhargalabelorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainhargatotalorder->Visible) { // lainhargatotalorder ?>
        <td data-name="lainhargatotalorder" <?= $Page->lainhargatotalorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainhargatotalorder">
<span<?= $Page->lainhargatotalorder->viewAttributes() ?>>
<?= $Page->lainhargatotalorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isibahanaktif->Visible) { // isibahanaktif ?>
        <td data-name="isibahanaktif" <?= $Page->isibahanaktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isibahanaktif">
<span<?= $Page->isibahanaktif->viewAttributes() ?>>
<?= $Page->isibahanaktif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isibahanlain->Visible) { // isibahanlain ?>
        <td data-name="isibahanlain" <?= $Page->isibahanlain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isibahanlain">
<span<?= $Page->isibahanlain->viewAttributes() ?>>
<?= $Page->isibahanlain->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isiparfum->Visible) { // isiparfum ?>
        <td data-name="isiparfum" <?= $Page->isiparfum->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isiparfum">
<span<?= $Page->isiparfum->viewAttributes() ?>>
<?= $Page->isiparfum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isiestetika->Visible) { // isiestetika ?>
        <td data-name="isiestetika" <?= $Page->isiestetika->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isiestetika">
<span<?= $Page->isiestetika->viewAttributes() ?>>
<?= $Page->isiestetika->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kemasanwadah->Visible) { // kemasanwadah ?>
        <td data-name="kemasanwadah" <?= $Page->kemasanwadah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasanwadah">
<span<?= $Page->kemasanwadah->viewAttributes() ?>>
<?= $Page->kemasanwadah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kemasantutup->Visible) { // kemasantutup ?>
        <td data-name="kemasantutup" <?= $Page->kemasantutup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasantutup">
<span<?= $Page->kemasantutup->viewAttributes() ?>>
<?= $Page->kemasantutup->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kemasansekunder->Visible) { // kemasansekunder ?>
        <td data-name="kemasansekunder" <?= $Page->kemasansekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasansekunder">
<span<?= $Page->kemasansekunder->viewAttributes() ?>>
<?= $Page->kemasansekunder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->desainlabel->Visible) { // desainlabel ?>
        <td data-name="desainlabel" <?= $Page->desainlabel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_desainlabel">
<span<?= $Page->desainlabel->viewAttributes() ?>>
<?= $Page->desainlabel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cetaklabel->Visible) { // cetaklabel ?>
        <td data-name="cetaklabel" <?= $Page->cetaklabel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_cetaklabel">
<span<?= $Page->cetaklabel->viewAttributes() ?>>
<?= $Page->cetaklabel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lainlain->Visible) { // lainlain ?>
        <td data-name="lainlain" <?= $Page->lainlain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lainlain">
<span<?= $Page->lainlain->viewAttributes() ?>>
<?= $Page->lainlain->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->deliverypickup->Visible) { // deliverypickup ?>
        <td data-name="deliverypickup" <?= $Page->deliverypickup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_deliverypickup">
<span<?= $Page->deliverypickup->viewAttributes() ?>>
<?= $Page->deliverypickup->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->deliverysinglepoint->Visible) { // deliverysinglepoint ?>
        <td data-name="deliverysinglepoint" <?= $Page->deliverysinglepoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_deliverysinglepoint">
<span<?= $Page->deliverysinglepoint->viewAttributes() ?>>
<?= $Page->deliverysinglepoint->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->deliverymultipoint->Visible) { // deliverymultipoint ?>
        <td data-name="deliverymultipoint" <?= $Page->deliverymultipoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_deliverymultipoint">
<span<?= $Page->deliverymultipoint->viewAttributes() ?>>
<?= $Page->deliverymultipoint->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->deliveryjumlahpoint->Visible) { // deliveryjumlahpoint ?>
        <td data-name="deliveryjumlahpoint" <?= $Page->deliveryjumlahpoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_deliveryjumlahpoint">
<span<?= $Page->deliveryjumlahpoint->viewAttributes() ?>>
<?= $Page->deliveryjumlahpoint->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->deliverytermslain->Visible) { // deliverytermslain ?>
        <td data-name="deliverytermslain" <?= $Page->deliverytermslain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_deliverytermslain">
<span<?= $Page->deliverytermslain->viewAttributes() ?>>
<?= $Page->deliverytermslain->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->catatankhusus->Visible) { // catatankhusus ?>
        <td data-name="catatankhusus" <?= $Page->catatankhusus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_catatankhusus">
<span<?= $Page->catatankhusus->viewAttributes() ?>>
<?= $Page->catatankhusus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <td data-name="dibuatdi" <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_dibuatdi">
<span<?= $Page->dibuatdi->viewAttributes() ?>>
<?= $Page->dibuatdi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal->Visible) { // tanggal ?>
        <td data-name="tanggal" <?= $Page->tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->created_by->Visible) { // created_by ?>
        <td data-name="created_by" <?= $Page->created_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_created_by">
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("npd_terms");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
