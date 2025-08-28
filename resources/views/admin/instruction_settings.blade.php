@extends('layouts.master')
@section('content')
<style>
    .instruction-preview {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%); 
        color: white; 
        padding: 10px; 
        border-radius: 5px; 
        margin-top: 10px; 
        overflow: hidden; 
        white-space: nowrap;
    }
    
    @keyframes scroll-left {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
    
    .instruction-preview:hover div {
        animation-play-state: paused;
    }
</style>

<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE CONTENT BODY -->
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN INSTRUCTION SETTINGS PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><i class="fa fa-bullhorn"></i> <b>{{ $title }}</b></h4>
                                        <small>Manage scrolling instruction text in header</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- Success/Error Messages -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                                </div>
                            @endif
                            
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
                                </div>
                            @endif
                            
                            <!-- Current Instruction Preview -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <h4><i class="fa fa-info-circle"></i> Current Instruction Preview:</h4>
                                        <div class="instruction-preview">
                                            <div style="display: inline-block; animation: scroll-left 30s linear infinite;">
                                                <i class="fa fa-bullhorn" style="margin-right: 10px;"></i>
                                                <strong>INSTRUCTION:</strong> 
                                                <span id="preview-text">{{ $current_instruction }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Update Form -->
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="instructionForm" method="POST" action="{{ route('updateInstruction') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label><strong>Instruction Text:</strong></label>
                                            <textarea class="form-control" id="instruction_text" name="instruction_text" rows="4" 
                                                      placeholder="Enter the instruction text that will scroll in the header..."
                                                      maxlength="500">{{ $current_instruction }}</textarea>
                                            <small class="help-block">Maximum 500 characters. This text will scroll continuously in the header bar.</small>
                                            <div class="text-right">
                                                <small class="text-muted">
                                                    <span id="char-count">{{ strlen($current_instruction) }}</span>/500 characters
                                                </small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn green">
                                                <i class="fa fa-save"></i> Update Instruction
                                            </button>
                                            <button type="button" class="btn blue" id="previewBtn">
                                                <i class="fa fa-eye"></i> Preview
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Instructions Panel -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h4><i class="fa fa-lightbulb-o"></i> Tips for Writing Instructions:</h4>
                                    <ul>
                                        <li>Keep it concise and clear</li>
                                        <li>Use important announcements or guidelines</li>
                                        <li>Avoid special characters that might break display</li>
                                        <li>Test with preview before saving</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h4><i class="fa fa-cogs"></i> How it Works:</h4>
                                    <ul>
                                        <li>Text scrolls from right to left</li>
                                        <li>Animation pauses on hover</li>
                                        <li>Visible on all pages in header</li>
                                        <li>Responsive design for mobile</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END INSTRUCTION SETTINGS PORTLET-->
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->
</div>

<script>
// Simple character counter without jQuery dependency
function updateCharCount() {
    var textarea = document.getElementById('instruction_text');
    var countSpan = document.getElementById('char-count');
    if (textarea && countSpan) {
        var length = textarea.value.length;
        countSpan.textContent = length;
        
        if (length > 450) {
            countSpan.className = 'text-danger';
        } else {
            countSpan.className = 'text-muted';
        }
    }
}

// Preview function without jQuery
function updatePreview() {
    var textarea = document.getElementById('instruction_text');
    var previewSpan = document.getElementById('preview-text');
    if (textarea && previewSpan) {
        previewSpan.textContent = textarea.value;
        alert('Preview updated! Check the preview box above.');
    }
}

// Add event listeners when page loads
document.addEventListener('DOMContentLoaded', function() {
    var textarea = document.getElementById('instruction_text');
    var previewBtn = document.getElementById('previewBtn');
    
    if (textarea) {
        textarea.addEventListener('input', updateCharCount);
    }
    
    if (previewBtn) {
        previewBtn.addEventListener('click', function(e) {
            e.preventDefault();
            updatePreview();
        });
    }
});
</script>
@endsection
