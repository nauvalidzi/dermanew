<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$SerahterimaAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fserahterimaadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fserahterimaadd = currentForm = new ew.Form("fserahterimaadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "serahterima")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.serahterima)
        ew.vars.tables.serahterima = currentTable;
    fserahterimaadd.addFields([
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["tanggalrequest", [fields.tanggalrequest.visible && fields.tanggalrequest.required ? ew.Validators.required(fields.tanggalrequest.caption) : null, ew.Validators.datetime(0)], fields.tanggalrequest.isInvalid],
        ["tanggalst", [fields.tanggalst.visible && fields.tanggalst.required ? ew.Validators.required(fields.tanggalst.caption) : null, ew.Validators.datetime(0)], fields.tanggalst.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fserahterimaadd,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fserahterimaadd.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fserahterimaadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fserahterimaadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fserahterimaadd.lists.idpegawai = <?= $Page->idpegawai->toClientList($Page) ?>;
    fserahterimaadd.lists.idcustomer = <?= $Page->idcustomer->toClientList($Page) ?>;
    loadjs.done("fserahterimaadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fserahterimaadd" id="fserahterimaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="serahterima">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label id="elh_serahterima_idpegawai" for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idpegawai->caption() ?><?= $Page->idpegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_serahterima_idpegawai">
<?php $Page->idpegawai->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idpegawai"
        name="x_idpegawai"
        class="form-control ew-select<?= $Page->idpegawai->isInvalidClass() ?>"
        data-select2-id="serahterima_x_idpegawai"
        data-table="serahterima"
        data-field="x_idpegawai"
        data-value-separator="<?= $Page->idpegawai->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idpegawai->getPlaceHolder()) ?>"
        <?= $Page->idpegawai->editAttributes() ?>>
        <?= $Page->idpegawai->selectOptionListHtml("x_idpegawai") ?>
    </select>
    <?= $Page->idpegawai->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idpegawai->getErrorMessage() ?></div>
<?= $Page->idpegawai->Lookup->getParamTag($Page, "p_x_idpegawai") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='serahterima_x_idpegawai']"),
        options = { name: "x_idpegawai", selectId: "serahterima_x_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.serahterima.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label id="elh_serahterima_idcustomer" for="x_idcustomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_serahterima_idcustomer">
<?php $Page->idcustomer->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idcustomer"
        name="x_idcustomer"
        class="form-control ew-select<?= $Page->idcustomer->isInvalidClass() ?>"
        data-select2-id="serahterima_x_idcustomer"
        data-table="serahterima"
        data-field="x_idcustomer"
        data-value-separator="<?= $Page->idcustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>"
        <?= $Page->idcustomer->editAttributes() ?>>
        <?= $Page->idcustomer->selectOptionListHtml("x_idcustomer") ?>
    </select>
    <?= $Page->idcustomer->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idcustomer->getErrorMessage() ?></div>
<?= $Page->idcustomer->Lookup->getParamTag($Page, "p_x_idcustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='serahterima_x_idcustomer']"),
        options = { name: "x_idcustomer", selectId: "serahterima_x_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.serahterima.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggalrequest->Visible) { // tanggalrequest ?>
    <div id="r_tanggalrequest" class="form-group row">
        <label id="elh_serahterima_tanggalrequest" for="x_tanggalrequest" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggalrequest->caption() ?><?= $Page->tanggalrequest->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggalrequest->cellAttributes() ?>>
<span id="el_serahterima_tanggalrequest">
<input type="<?= $Page->tanggalrequest->getInputTextType() ?>" data-table="serahterima" data-field="x_tanggalrequest" name="x_tanggalrequest" id="x_tanggalrequest" placeholder="<?= HtmlEncode($Page->tanggalrequest->getPlaceHolder()) ?>" value="<?= $Page->tanggalrequest->EditValue ?>"<?= $Page->tanggalrequest->editAttributes() ?> aria-describedby="x_tanggalrequest_help">
<?= $Page->tanggalrequest->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggalrequest->getErrorMessage() ?></div>
<?php if (!$Page->tanggalrequest->ReadOnly && !$Page->tanggalrequest->Disabled && !isset($Page->tanggalrequest->EditAttrs["readonly"]) && !isset($Page->tanggalrequest->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fserahterimaadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fserahterimaadd", "x_tanggalrequest", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggalst->Visible) { // tanggalst ?>
    <div id="r_tanggalst" class="form-group row">
        <label id="elh_serahterima_tanggalst" for="x_tanggalst" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggalst->caption() ?><?= $Page->tanggalst->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggalst->cellAttributes() ?>>
<span id="el_serahterima_tanggalst">
<input type="<?= $Page->tanggalst->getInputTextType() ?>" data-table="serahterima" data-field="x_tanggalst" name="x_tanggalst" id="x_tanggalst" placeholder="<?= HtmlEncode($Page->tanggalst->getPlaceHolder()) ?>" value="<?= $Page->tanggalst->EditValue ?>"<?= $Page->tanggalst->editAttributes() ?> aria-describedby="x_tanggalst_help">
<?= $Page->tanggalst->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggalst->getErrorMessage() ?></div>
<?php if (!$Page->tanggalst->ReadOnly && !$Page->tanggalst->Disabled && !isset($Page->tanggalst->EditAttrs["readonly"]) && !isset($Page->tanggalst->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fserahterimaadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fserahterimaadd", "x_tanggalst", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_serahterima_created_by">
    <input type="hidden" data-table="serahterima" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
</div><!-- /page* -->
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("npd_sample", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "NpdSampleGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("serahterima");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
