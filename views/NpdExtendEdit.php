<?php

namespace PHPMaker2021\Dermateknonew;

// Page object
$NpdExtendEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_extendedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnpd_extendedit = currentForm = new ew.Form("fnpd_extendedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_extend")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_extend)
        ew.vars.tables.npd_extend = currentTable;
    fnpd_extendedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["tglbayar", [fields.tglbayar.visible && fields.tglbayar.required ? ew.Validators.required(fields.tglbayar.caption) : null, ew.Validators.datetime(0)], fields.tglbayar.isInvalid],
        ["buktipembayaran", [fields.buktipembayaran.visible && fields.buktipembayaran.required ? ew.Validators.required(fields.buktipembayaran.caption) : null], fields.buktipembayaran.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null, ew.Validators.integer], fields.created_by.isInvalid],
        ["readonly", [fields.readonly.visible && fields.readonly.required ? ew.Validators.required(fields.readonly.caption) : null], fields.readonly.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_extendedit,
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
    fnpd_extendedit.validate = function () {
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
    fnpd_extendedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_extendedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_extendedit.lists.readonly = <?= $Page->readonly->toClientList($Page) ?>;
    loadjs.done("fnpd_extendedit");
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
<form name="fnpd_extendedit" id="fnpd_extendedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_extend">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_npd_extend_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_npd_extend_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_extend" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_extend_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_extend_idnpd">
<input type="<?= $Page->idnpd->getInputTextType() ?>" data-table="npd_extend" data-field="x_idnpd" name="x_idnpd" id="x_idnpd" size="30" placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>" value="<?= $Page->idnpd->EditValue ?>"<?= $Page->idnpd->editAttributes() ?> aria-describedby="x_idnpd_help">
<?= $Page->idnpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglbayar->Visible) { // tglbayar ?>
    <div id="r_tglbayar" class="form-group row">
        <label id="elh_npd_extend_tglbayar" for="x_tglbayar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglbayar->caption() ?><?= $Page->tglbayar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglbayar->cellAttributes() ?>>
<span id="el_npd_extend_tglbayar">
<input type="<?= $Page->tglbayar->getInputTextType() ?>" data-table="npd_extend" data-field="x_tglbayar" name="x_tglbayar" id="x_tglbayar" placeholder="<?= HtmlEncode($Page->tglbayar->getPlaceHolder()) ?>" value="<?= $Page->tglbayar->EditValue ?>"<?= $Page->tglbayar->editAttributes() ?> aria-describedby="x_tglbayar_help">
<?= $Page->tglbayar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglbayar->getErrorMessage() ?></div>
<?php if (!$Page->tglbayar->ReadOnly && !$Page->tglbayar->Disabled && !isset($Page->tglbayar->EditAttrs["readonly"]) && !isset($Page->tglbayar->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_extendedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_extendedit", "x_tglbayar", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->buktipembayaran->Visible) { // buktipembayaran ?>
    <div id="r_buktipembayaran" class="form-group row">
        <label id="elh_npd_extend_buktipembayaran" for="x_buktipembayaran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->buktipembayaran->caption() ?><?= $Page->buktipembayaran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->buktipembayaran->cellAttributes() ?>>
<span id="el_npd_extend_buktipembayaran">
<input type="<?= $Page->buktipembayaran->getInputTextType() ?>" data-table="npd_extend" data-field="x_buktipembayaran" name="x_buktipembayaran" id="x_buktipembayaran" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->buktipembayaran->getPlaceHolder()) ?>" value="<?= $Page->buktipembayaran->EditValue ?>"<?= $Page->buktipembayaran->editAttributes() ?> aria-describedby="x_buktipembayaran_help">
<?= $Page->buktipembayaran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->buktipembayaran->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_npd_extend_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_npd_extend_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="npd_extend" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_extendedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_extendedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <div id="r_created_by" class="form-group row">
        <label id="elh_npd_extend_created_by" for="x_created_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_by->caption() ?><?= $Page->created_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_by->cellAttributes() ?>>
<span id="el_npd_extend_created_by">
<input type="<?= $Page->created_by->getInputTextType() ?>" data-table="npd_extend" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>" value="<?= $Page->created_by->EditValue ?>"<?= $Page->created_by->editAttributes() ?> aria-describedby="x_created_by_help">
<?= $Page->created_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->readonly->Visible) { // readonly ?>
    <div id="r_readonly" class="form-group row">
        <label id="elh_npd_extend_readonly" class="<?= $Page->LeftColumnClass ?>"><?= $Page->readonly->caption() ?><?= $Page->readonly->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->readonly->cellAttributes() ?>>
<span id="el_npd_extend_readonly">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->readonly->isInvalidClass() ?>" data-table="npd_extend" data-field="x_readonly" name="x_readonly[]" id="x_readonly_521177" value="1"<?= ConvertToBool($Page->readonly->CurrentValue) ? " checked" : "" ?><?= $Page->readonly->editAttributes() ?> aria-describedby="x_readonly_help">
    <label class="custom-control-label" for="x_readonly_521177"></label>
</div>
<?= $Page->readonly->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->readonly->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("npd_extend");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
