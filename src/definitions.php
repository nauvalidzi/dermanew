<?php

namespace PHPMaker2021\Dermateknonew;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "pegawai" => \DI\create(Pegawai::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "customer" => \DI\create(Customer::class),
    "alamat_customer" => \DI\create(AlamatCustomer::class),
    "tipecustomer" => \DI\create(Tipecustomer::class),
    "brand" => \DI\create(Brand::class),
    "provinsi" => \DI\create(Provinsi::class),
    "kabupaten" => \DI\create(Kabupaten::class),
    "kecamatan" => \DI\create(Kecamatan::class),
    "kelurahan" => \DI\create(Kelurahan::class),
    "product" => \DI\create(Product::class),
    "d_jatuhtempo" => \DI\create(DJatuhtempo::class),
    "kategoribarang" => \DI\create(Kategoribarang::class),
    "jenisbarang" => \DI\create(Jenisbarang::class),
    "kemasanbarang" => \DI\create(Kemasanbarang::class),
    "kualitasbarang" => \DI\create(Kualitasbarang::class),
    "aplikasibarang" => \DI\create(Aplikasibarang::class),
    "viskositasbarang" => \DI\create(Viskositasbarang::class),
    "ekspedisi" => \DI\create(Ekspedisi::class),
    "rekening" => \DI\create(Rekening::class),
    "satuan" => \DI\create(Satuan::class),
    "npd" => \DI\create(Npd::class),
    "npd_terms" => \DI\create(NpdTerms::class),
    "npd_status" => \DI\create(NpdStatus::class),
    "npd_sample" => \DI\create(NpdSample::class),
    "npd_review" => \DI\create(NpdReview::class),
    "npd_extend" => \DI\create(NpdExtend::class),
    "npd_confirm" => \DI\create(NpdConfirm::class),
    "npd_harga" => \DI\create(NpdHarga::class),
    "serahterima" => \DI\create(Serahterima::class),
    "ijinhaki" => \DI\create(Ijinhaki::class),
    "ijinhaki_status" => \DI\create(IjinhakiStatus::class),
    "ijinbpom" => \DI\create(Ijinbpom::class),
    "ijinbpom_detail" => \DI\create(IjinbpomDetail::class),
    "ijinbpom_status" => \DI\create(IjinbpomStatus::class),
    "order" => \DI\create(Order::class),
    "order_detail" => \DI\create(OrderDetail::class),
    "deliveryorder" => \DI\create(Deliveryorder::class),
    "deliveryorder_detail" => \DI\create(DeliveryorderDetail::class),
    "invoice" => \DI\create(Invoice::class),
    "invoice_detail" => \DI\create(InvoiceDetail::class),
    "suratjalan" => \DI\create(Suratjalan::class),
    "suratjalan_detail" => \DI\create(SuratjalanDetail::class),
    "pembayaran" => \DI\create(Pembayaran::class),
    "termpayment" => \DI\create(Termpayment::class),
    "tipepayment" => \DI\create(Tipepayment::class),
    "v_bonuscustomer" => \DI\create(VBonuscustomer::class),
    "v_orderdetail" => \DI\create(VOrderdetail::class),
    "v_piutang" => \DI\create(VPiutang::class),
    "v_piutang_detail" => \DI\create(VPiutangDetail::class),
    "v_stock" => \DI\create(VStock::class),
    "redeembonus" => \DI\create(Redeembonus::class),
    "dashboard2" => \DI\create(Dashboard2::class),
    "p_invoice" => \DI\create(PInvoice::class),
    "p_suratjalan" => \DI\create(PSuratjalan::class),
    "stock" => \DI\create(Stock::class),
    "titipmerk_validasi" => \DI\create(TitipmerkValidasi::class),
    "maklon_produk" => \DI\create(MaklonProduk::class),

    // User table
    "usertable" => \DI\get("pegawai"),
];
