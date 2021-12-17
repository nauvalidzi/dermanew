<?php

namespace PHPMaker2021\Dermateknonew;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(473, "mi_dashboard2", $MenuLanguage->MenuPhrase("473", "MenuText"), $MenuRelativePath . "Dashboard2", -1, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}dashboard.php'), false, false, "fas fa-home", "", false);
$sideMenu->addMenuItem(15, "mi_pegawai", $MenuLanguage->MenuPhrase("15", "MenuText"), $MenuRelativePath . "PegawaiList", -1, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}pegawai'), false, false, "fa-id-card-alt fas", "", false);
$sideMenu->addMenuItem(8, "mi_customer", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "CustomerList?cmd=resetall", -1, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}customer'), false, false, "fa-users fas", "", false);
$sideMenu->addMenuItem(9, "mi_product", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "ProductList?cmd=resetall", -1, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}product'), false, false, "fa-cubes fas", "", false);
$sideMenu->addMenuItem(479, "mi_maklon_produk", $MenuLanguage->MenuPhrase("479", "MenuText"), $MenuRelativePath . "MaklonProduk", -1, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}maklon_produk.php'), false, false, "fa-dice fas", "", false);
$sideMenu->addMenuItem(96, "mci_Titip_Merk", $MenuLanguage->MenuPhrase("96", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "far fa-copyright", "", false);
$sideMenu->addMenuItem(283, "mi_ijinhaki", $MenuLanguage->MenuPhrase("283", "MenuText"), $MenuRelativePath . "IjinhakiList", 96, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinhaki'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(306, "mi_ijinbpom", $MenuLanguage->MenuPhrase("306", "MenuText"), $MenuRelativePath . "IjinbpomList", 96, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}ijinbpom'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(50, "mci_Transaksi", $MenuLanguage->MenuPhrase("50", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fas fa-shopping-cart", "", false);
$sideMenu->addMenuItem(318, "mi_order", $MenuLanguage->MenuPhrase("318", "MenuText"), $MenuRelativePath . "OrderList", 50, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}order'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(321, "mi_deliveryorder", $MenuLanguage->MenuPhrase("321", "MenuText"), $MenuRelativePath . "DeliveryorderList", 50, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}deliveryorder'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(326, "mi_invoice", $MenuLanguage->MenuPhrase("326", "MenuText"), $MenuRelativePath . "InvoiceList", 50, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}invoice'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(330, "mi_suratjalan", $MenuLanguage->MenuPhrase("330", "MenuText"), $MenuRelativePath . "SuratjalanList", 50, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}suratjalan'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(334, "mi_pembayaran", $MenuLanguage->MenuPhrase("334", "MenuText"), $MenuRelativePath . "PembayaranList", 50, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}pembayaran'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(403, "mci_Referensi", $MenuLanguage->MenuPhrase("403", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-book-open fas", "", false);
$sideMenu->addMenuItem(325, "mi_ekspedisi", $MenuLanguage->MenuPhrase("325", "MenuText"), $MenuRelativePath . "EkspedisiList", 403, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}ekspedisi'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(101, "mi_tipepayment", $MenuLanguage->MenuPhrase("101", "MenuText"), $MenuRelativePath . "TipepaymentList", 403, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}tipepayment'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(102, "mi_termpayment", $MenuLanguage->MenuPhrase("102", "MenuText"), $MenuRelativePath . "TermpaymentList", 403, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}termpayment'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(10, "mi_jenisbarang", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "JenisbarangList", 403, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}jenisbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(11, "mi_kategoribarang", $MenuLanguage->MenuPhrase("11", "MenuText"), $MenuRelativePath . "KategoribarangList", 403, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}kategoribarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(113, "mi_kualitasbarang", $MenuLanguage->MenuPhrase("113", "MenuText"), $MenuRelativePath . "KualitasbarangList", 403, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}kualitasbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(314, "mi_kemasanbarang", $MenuLanguage->MenuPhrase("314", "MenuText"), $MenuRelativePath . "KemasanbarangList", 403, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}kemasanbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(472, "mi_viskositasbarang", $MenuLanguage->MenuPhrase("472", "MenuText"), $MenuRelativePath . "ViskositasbarangList", 403, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}viskositasbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(471, "mi_aplikasibarang", $MenuLanguage->MenuPhrase("471", "MenuText"), $MenuRelativePath . "AplikasibarangList", 403, "", AllowListMenu('{E0FDE1D0-889A-402F-A577-286E80B13C3A}aplikasibarang'), false, false, "far fa-circle", "", false);
echo $sideMenu->toScript();
