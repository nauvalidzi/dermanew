<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$IjinhakiEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fijinhakiedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fijinhakiedit = currentForm = new ew.Form("fijinhakiedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ijinhaki")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ijinhaki)
        ew.vars.tables.ijinhaki = currentTable;
    fijinhakiedit.addFields([
        ["buktibayar", [fields.buktibayar.visible && fields.buktibayar.required ? ew.Validators.fileRequired(fields.buktibayar.caption) : null], fields.buktibayar.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fijinhakiedit,
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
    fijinhakiedit.validate = function () {
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
    fijinhakiedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fijinhakiedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fijinhakiedit");
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
<form name="fijinhakiedit" id="fijinhakiedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinhaki">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->buktibayar->Visible) { // buktibayar ?>
    <div id="r_buktibayar" class="form-group row">
        <label id="elh_ijinhaki_buktibayar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buktibayar->caption() ?><?= $Page->buktibayar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->buktibayar->cellAttributes() ?>>
<span id="el_ijinhaki_buktibayar">
<div id="fd_x_buktibayar">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->buktibayar->title() ?>" data-table="ijinhaki" data-field="x_buktibayar" name="x_buktibayar" id="x_buktibayar" lang="<?= CurrentLanguageID() ?>"<?= $Page->buktibayar->editAttributes() ?><?= ($Page->buktibayar->ReadOnly || $Page->buktibayar->Disabled) ? " disabled" : "" ?> aria-describedby="x_buktibayar_help">
        <label class="custom-file-label ew-file-label" for="x_buktibayar"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->buktibayar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buktibayar->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_buktibayar" id= "fn_x_buktibayar" value="<?= $Page->buktibayar->Upload->FileName ?>">
<input type="hidden" name="fa_x_buktibayar" id= "fa_x_buktibayar" value="<?= (Post("fa_x_buktibayar") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_buktibayar" id= "fs_x_buktibayar" value="255">
<input type="hidden" name="fx_x_buktibayar" id= "fx_x_buktibayar" value="<?= $Page->buktibayar->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_buktibayar" id= "fm_x_buktibayar" value="<?= $Page->buktibayar->UploadMaxFileSize ?>">
</div>
<table id="ft_x_buktibayar" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="ijinhaki" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php
    if (in_array("ijinhaki_status", explode(",", $Page->getCurrentDetailTable())) && $ijinhaki_status->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("ijinhaki_status", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "IjinhakiStatusGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("ijinhaki");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
