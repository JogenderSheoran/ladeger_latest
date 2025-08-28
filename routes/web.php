<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\shiftController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MedicineController;




Route::get('/', function () {
    return view('welcome');
});
Route::post('login', [LoginController::class,'login']);

Auth::routes();

Route::get('/home',[HomeController::class,'index'])->name('home');
Route::get('/new',[HomeController::class,'new'])->name('new');


Route::middleware(['auth'])->group(function () {

    // Reports
    Route::get('profile',[HomeController::class,'profile'])->name('profile');
    Route::post('change-password',[HomeController::class,'change_password'])->name('change_password');
    Route::get('daily-report',[ReportController::class,'daily_report'])->name('daily_report');
    Route::get('filter-report',[ReportController::class,'filter_report'])->name('filter_report');
    Route::get('all-shift-report',[ReportController::class,'all_shift_report'])->name('all_shift_report');
    Route::get('settling-report',[ReportController::class,'settling_report'])->name('settling_report');
    Route::get('profit-loss-report',[ReportController::class,'profit_loss_report'])->name('profit_loss_report');
    Route::get('limit-balance-report',[ReportController::class,'limit_balance_report'])->name('limit_balance_report');


    // Shift
        Route::get('shift',[shiftController::class,'shift'])->name('shift');

    // Transaction
    Route::get('transaction',[TransactionController::class,'transaction'])->name('transaction');
    Route::get('user-transaction/{id}',[TransactionController::class,'user_transaction'])->name('user_transaction');
    Route::get('transaction-list',[TransactionController::class,'transaction_list'])->name('transaction_list');
    Route::get('declared-transaction',[TransactionController::class,'declared_transaction'])->name('declared_transaction');
    Route::get('transaction-popup',[TransactionController::class,'transaction_popup'])->name('transaction_popup');
    Route::get('add-transaction/{id}',[TransactionController::class,'add_transaction'])->name('add_transaction');
    Route::get('edit-transaction/{id}',[TransactionController::class,'edit_transaction'])->name('edit_transaction');
    Route::post('get-ledger',[TransactionController::class,'get_ledger'])->name('get_ledger');

    // Staff
        Route::get('staff',[shiftController::class,'staff'])->name('staff');

    // Id Cutter
        Route::get('id-cutter',[shiftController::class,'id_cutter'])->name('id_cutter');

    //Agents  
        Route::get('agents',[shiftController::class,'agents'])->name('agents');  
      
    //Ledgers    
        Route::get('ledgers',[shiftController::class,'ledgers'])->name('ledgers');  
        Route::post('add_ledger',[shiftController::class,'add_ledger'])->name('add_ledger');
        Route::post('submit-ledger',[shiftController::class,'submit_ledger'])->name('submit_ledger');
        Route::get('edit-ledger/{id}',[shiftController::class,'edit_ledger'])->name('edit_ledger');
        Route::post('update-ledger',[shiftController::class,'update_ledger'])->name('update_ledger');
        Route::post('update_ledger_thpc',[shiftController::class,'update_ledger_thpc'])->name('update_ledger_thpc');
        Route::post('search_ledger_data',[shiftController::class,'search_ledger_data'])->name('search_ledger_data');
        Route::post('search_admin_data',[shiftController::class,'search_admin_data'])->name('search_admin_data');
        Route::post('search_punter_data',[shiftController::class,'search_punter_data'])->name('search_punter_data');
        Route::post('get_ledger_medicine',[shiftController::class,'getLedgerMedicine'])->name('getLedgerMedicine');

    //Voucher routes
    Route::get('journal-voucher',[VoucherController::class,'journal_voucher'])->name('journal_voucher');
    Route::get('medicine-transaction',[VoucherController::class,'medicine_transaction'])->name('medicineTransaction');
    Route::post('medicine-transactions-ajax',[VoucherController::class,'getMedicineTransactionsAjax'])->name('medicineTransactionsAjax');
    Route::post('delete-transaction',[VoucherController::class,'deleteTransaction'])->name('deleteTransaction');
    Route::get('medicine-totals',[VoucherController::class,'getMedicineTotals'])->name('getMedicineTotals');
    Route::get('medicine-transaction/{id}',[VoucherController::class,'ledgerMedicineTransaction'])->name('ledgerMedicineTransaction');
    Route::get('ledger-report/{id}',[VoucherController::class,'ledger_report'])->name('ledger_report');
    Route::get('archieve-transaction',[VoucherController::class,'archieve_transaction'])->name('archieve_transaction');
    Route::post('ledger-medicine',[VoucherController::class,'ledgerMedicine'])->name('ledgerMedicine');
    Route::post('ledger-medicine-list',[VoucherController::class,'ledgerMedicineList'])->name('ledgerMedicineList');
    Route::post('ledger-bill-update',[VoucherController::class,'ledgerBillUpdate'])->name('ledgerBillUpdate');
   
    //Prediction routes
    Route::get('prediction',[PredictionController::class,'prediction'])->name('prediction');
    Route::post('declare-number',[PredictionController::class,'declare_number'])->name('declare_number');

    //Transaction 
    Route::post('fetch_transaction',[TransactionController::class,'fetch_transaction'])->name('fetch_transaction');
    Route::post('fetch_mainjantri_transaction',[TransactionController::class,'fetch_mainjantri_transaction'])->name('fetch_mainjantri_transaction');

    Route::get('notes',[TransactionController::class,'notes'])->name('notes');
    Route::post('create-notes',[TransactionController::class,'createNote'])->name('createNotes');
    Route::get('edit-notes/{id}',[TransactionController::class,'edit_notes'])->name('editeNotes');
    Route::post('update-notes',[TransactionController::class,'updateNotes'])->name('updateNotes');
    Route::post('delete-notes',[TransactionController::class,'deleteNotes'])->name('deleteNotes');
    // Route::post('delete-admin',[TransactionController::class,'deleteAdmin'])->name('deleteAdmin');

    Route::get('admin',[AdminUserController::class,'admins'])->name('admin');
    Route::post('admin',[AdminUserController::class,'createAdmin'])->name('createAdmin');
    Route::get('instruction-settings',[AdminUserController::class,'instructionSettings'])->name('instructionSettings');
    Route::post('update-instruction',[AdminUserController::class,'updateInstruction'])->name('updateInstruction');
    Route::get('edit-admin/{id}',[AdminUserController::class,'editAdmin'])->name('editAdmin');
    Route::post('update-admin',[AdminUserController::class,'updateAdmin'])->name('updateAdmin');
    Route::post('delete-admin',[TransactionController::class,'deleteAdmin'])->name('deleteAdmin');

    Route::get('medicine',[MedicineController::class,'medicineList'])->name('medicineList');
    Route::get('add-medicine',[MedicineController::class,'addMedicine'])->name('addMedicine');
    Route::post('create-medicine',[MedicineController::class,'createMedicine'])->name('createMedicine');
    Route::get('edit-medicine/{id}',[MedicineController::class,'editMedicine'])->name('editMedicine');
    Route::post('update-medicine',[MedicineController::class,'updateMedicine'])->name('updateMedicine');
    Route::post('delete-medicine',[MedicineController::class,'deleteMedicine'])->name('deleteMedicine');

    Route::get('medicine-list',[MedicineController::class,'medicineListTransaction'])->name('medicineListTransaction');
    Route::get('add-medicine-transaction',[MedicineController::class,'addMedicineTransaction'])->name('addMedicineTransaction');
    Route::post('create-medicine-transaction',[MedicineController::class,'createMedicineTransaction'])->name('createMedicineTransaction');
    Route::get('edit-medicine-transaction/{id}',[MedicineController::class,'editMedicineTransation'])->name('editMedicineTransaction');
    Route::post('update-medicine-transaction',[MedicineController::class,'updateMedicineTransaction'])->name('updateMedicineTransaction');
    Route::post('delete-medicine-transaction',[MedicineController::class,'deleteMedicineTransaction'])->name('deleteMedicineTransaction');
    

});