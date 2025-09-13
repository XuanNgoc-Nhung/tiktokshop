<?php

return [
    // Page title
    'title' => 'Withdraw',
    'subtitle' => 'Withdraw money to your bank account',
    
    // Current balance
    'current_balance' => 'Current Balance',
    'available_balance' => 'Available Balance',
    'last_updated' => 'Last Updated',
    'currency' => 'USD',
    
    // Bank information
    'bank_info' => 'Bank',
    'bank_name' => 'Bank Name',
    'bank_name_placeholder' => 'e.g. Vietcombank, Techcombank, BIDV...',
    'account_holder' => 'Account Holder Name',
    'account_holder_placeholder' => 'Enter account holder name',
    'account_number' => 'Account Number',
    'account_number_placeholder' => 'Enter bank account number',
    'branch' => 'Branch',
    'branch_placeholder' => 'Enter bank branch',
    
    // Withdrawal amount
    'withdrawal_amount' => 'Amount',
    'amount_placeholder' => 'Enter amount',
    'min_amount' => 'Min',
    'max_amount' => 'Max',
    'fee' => 'Transaction Fee',
    'total_amount' => 'Total Amount Received',
    
    // Quick amount buttons
    'quick_amounts' => 'Quick',
    'amount_10' => '$10',
    'amount_50' => '$50',
    'amount_100' => '$100',
    'amount_200' => '$200',
    'amount_500' => '$500',
    'amount_1000' => '$1000',
    
    // Withdrawal password
    'withdrawal_password' => 'Withdrawal Password',
    'password_placeholder' => 'Enter withdrawal password',
    'forgot_password' => 'Forgot Password?',
    'set_password' => 'Set Withdrawal Password',
    
    // Form buttons
    'submit_withdrawal' => 'Confirm',
    'cancel' => 'Cancel',
    'confirm' => 'Confirm',
    
    // Validation messages
    'bank_name_required' => 'Please enter bank name',
    'account_holder_required' => 'Please enter account holder name',
    'account_number_required' => 'Please enter account number',
    'account_number_numeric' => 'Account number must be numeric',
    'amount_required' => 'Please enter amount',
    'amount_numeric' => 'Amount must be numeric',
    'amount_min' => 'Min $:min',
    'amount_max' => 'Max $:max',
    'amount_insufficient' => 'Insufficient balance for this transaction',
    'password_required' => 'Please enter withdrawal password',
    'password_incorrect' => 'Incorrect withdrawal password',
    
    // Success messages
    'withdrawal_success' => 'Withdrawal successful',
    'withdrawal_pending' => 'Withdrawal request is pending',
    'withdrawal_processing' => 'System is processing your withdrawal request',
    
    // Error messages
    'withdrawal_failed' => 'Withdrawal failed',
    'try_again' => 'Please try again later',
    'contact_support' => 'Contact support if the problem persists',
    
    // Instructions
    'instructions_title' => 'Instructions',
    'step_1' => 'Enter bank information',
    'step_2' => 'Enter amount (minimum $10)',
    'step_3' => 'Enter withdrawal password',
    'step_4' => 'Process within 24h',
    
    // Notes
    'note_title' => 'Notes',
    'note_1' => 'Bank information 100% accurate',
    'note_2' => 'No fees',
    'note_3' => 'Process: 1-24h',
    'note_4' => 'Contact support if issues',
    
    // Password setup
    'password_not_set' => 'Withdrawal password not set',
    'password_setup_required' => 'Set Password Required',
    'go_to_password' => 'Set Password',
    
    // Navigation
    'back' => 'Back',
    
    // Bank info messages
    'edit_bank_info' => 'Edit bank information',
    'no_bank_info_title' => 'No bank information',
    'no_bank_info_message' => 'You need to update your bank information before you can withdraw money.',
    'update_bank_info' => 'Update bank information',
    'bank_info_required' => 'Bank information required',
    
    // Toast messages
    'toast_notification' => 'Notification',
    'toast_warning' => 'Warning',
    'toast_error' => 'Error',
    'toast_success' => 'Success',
    'toast_info' => 'Info',
    'toast_processing' => 'Processing',
    'toast_validation_error' => 'Validation Error',
    'toast_connection_error' => 'Connection Error',
    
    // JavaScript messages
    'js_bank_info_required' => 'You need to update your bank information before you can withdraw money.',
    'js_password_required' => 'You need to set up your withdrawal password before you can make transactions.',
    'js_amount_selected' => 'Selected',
    'js_amount_valid' => 'Valid',
    'js_amount_exceeds' => 'Amount exceeds maximum withdrawable amount',
    'js_min_amount_error' => 'Minimum withdrawal amount is $10',
    'js_max_amount_error' => 'Amount exceeds maximum withdrawable amount',
    'js_password_required_error' => 'Please enter withdrawal password',
    'js_processing' => 'Processing...',
    'js_processing_request' => 'Sending withdrawal request, please wait...',
    'js_form_reset' => 'Form reset',
    'js_new_transaction' => 'You can make a new transaction',
    'js_request_error' => 'An error occurred while processing the request',
    'js_connection_error' => 'An error occurred while connecting to the server. Please check your internet connection and try again.',
    'js_withdrawal_amount' => 'Withdrawal amount',
];
