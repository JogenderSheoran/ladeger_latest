<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//API
use App\Http\Controllers\api\shiftController;
use App\Http\Controllers\api\userController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\PredictionController;
use App\Http\Controllers\api\ReportController;
use App\Http\Controllers\api\MedicineController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Report
    Route::post('daily_report',[ReportController::class,'daily_report']);
    Route::post('profit_loss_data',[ReportController::class,'profit_loss_data']);
    Route::post('limit_balance_report',[ReportController::class,'limit_balance_report']);
    Route::post('all_shift_report',[ReportController::class,'all_shift_report']);
    Route::post('settling_report',[ReportController::class,'settling_report']);
    Route::post('ledger_daily_report',[ReportController::class,'ledger_daily_report']);
    Route::post('change_status',[shiftController::class,'change_status']);
    Route::get('update_ledger',[shiftController::class,'update_ledger']);
    Route::post('add_medicine_transaction',[shiftController::class,'add_medicine_transaction']);



// Shift
    Route::post('add_shift',[shiftController::class,'addShift']);
    Route::post('add_ledger',[shiftController::class,'ledger']);
    Route::post('add_shaff',[shiftController::class,'addShaff']);
    Route::post('add_agent',[shiftController::class,'addAgent']);
    Route::post('add_id_cutter',[shiftController::class,'addidCutter']);
    
    Route::post('add_journal_voucher',[shiftController::class,'add_journal_voucher']);
    Route::post('edit_journal_voucher',[shiftController::class,'edit_journal_voucher']);
    Route::post('search_ledger',[shiftController::class,'search_ledger']);
    Route::post('delete_shift',[shiftController::class,'delete_shift']);
    Route::post('search_shift',[shiftController::class,'search_shift']);
    Route::post('delete_staff',[shiftController::class,'delete_staff']);
    Route::post('delete_ledger',[shiftController::class,'delete_ledger']);
    Route::post('delete_voucher',[shiftController::class,'delete_voucher']);
    Route::post('archieve_voucher',[shiftController::class,'archieve_voucher']);
    Route::post('unarchieve_voucher',[shiftController::class,'unarchieve_voucher']);
    Route::post('archieve_ledger',[shiftController::class,'archieve_ledger']);
    Route::post('unarchieve_ledger',[shiftController::class,'unarchieve_ledger']);
    

    Route::post('prediction_data',[PredictionController::class,'prediction_data']);
    Route::post('declare_number',[PredictionController::class,'declare_number']);
    Route::post('redeclare_number',[PredictionController::class,'redeclare_number']);
    Route::post('remove_number',[PredictionController::class,'remove_number']);
    Route::post('prediction_list',[PredictionController::class,'prediction_list']);


//get leddger
    Route::post('get_ledgers',[shiftcontroller::class,'get_ledgers']);
//auto complete search suggestion
    Route::post('autocompelete_ledger',[shiftcontroller::class,'autocompelete_ledger']);
    Route::post('autocompelete_transaction_ledger',[shiftcontroller::class,'autocompelete_transaction_ledger']);
//update basic detail ledger
    Route::post('update_basic_ledger',[shiftcontroller::class,'update_basic_ledger']);
    Route::post('update_reconfig_rate',[shiftcontroller::class,'update_reconfig_rate']);

//auto complete id cutter suggestion
    Route::post('autocompelete_punter_id',[shiftcontroller::class,'autocompelete_punter_id']);

// Transaction
    Route::post('update_transaction',[TransactionController::class,'update_transaction']);
    Route::post('transaction_detail',[TransactionController::class,'transaction_detail']);
    Route::post('fetch_transaction',[TransactionController::class,'fetch_transaction']);
    Route::post('copy_transaction',[TransactionController::class,'copy_transaction']);
    Route::post('delete_transaction',[TransactionController::class,'delete_transaction']);
    

//Auth
    Route::post('login',[userController::class,'login']);
    Route::post('change_password',[userController::class,'changePassword']);
    Route::post('update_player',[userController::class,'updatePlayer']);
    Route::post('your_shift',[userController::class,'yourShift']);
    Route::post('cutting_shift',[userController::class,'cuttingShift']);
    Route::post('user_info',[userController::class,'user_info']);
    Route::post('party_info',[userController::class,'party_info']);
    Route::post('update_info',[userController::class,'update_info']);
    Route::get('update_detail',[userController::class,'update_detail']);

    Route::post('/medicine-insert', [MedicineController::class, 'insertMedicine']);
    Route::post('/medicine-transaction-add', [MedicineController::class, 'addTransaction']);
    Route::get('/medicine-list', [MedicineController::class, 'getMedicineList']);
    Route::get('/ledger-list', [MedicineController::class, 'getLedgerList']);
    Route::get('/get-last-price', [MedicineController::class, 'getLastPrice']);
    Route::post('/get-ledger-data', [MedicineController::class, 'getLedgerData']);
    Route::post('/get-ledger-medicine', [MedicineController::class, 'getLedgerMedicine']);
    Route::post('/get-last-price', [MedicineController::class, 'getLastPrice']);
    Route::post('/get-medicine-transaction',[MedicineController::class, 'getMedicineTransaction']);

