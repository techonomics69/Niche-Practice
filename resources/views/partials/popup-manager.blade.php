<div id="main-modal" class="modal welcome-process fade in modal-manager" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="display: none;">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
        </div>

        <form class="wizard-container" method="POST" action="#" id="js-wizard-form">
            <div class="modal-body">
                <div class="page-title">
                    <h2 class="popup-title" style="text-align: center;">
                        Please wait while we create your account
                        <br>
                        <span class="seconds45" >(this could take up to 45 seconds...)</span>
                    </h2>
                </div>
            </div>
            <div class="modal-footer">
                <div class="progress-section">

                    <div class="row">
                        <div class="col-sm-4 col-xs-4 setting-screen-col">
                            <div class="progress" id="js-progress">
                                <div class="progress-bar account-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100" style="width: 40%;">
                                    <span class="progress-val">40%</span>
                                </div>
                            </div>
                            <h5 class="progress-text account text-center" style="margin: 0px;">Setting Up Your Account</h5>
                        </div>
                        <div class="col-sm-4 col-xs-4">
                            <div class="progress" id="js-progress">
                                <div class="progress-bar collect-data-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100">
                                    <span class="progress-val">40%</span>
                                </div>
                            </div>
{{--                            <h5 class="progress-text">Gathering data from the Internet</h5>--}}
                            <h5 class="progress-text">Analyzing Your SEO</h5>
                            {{-- <img class="process-loader"
                                src="{{ asset('public/images/blue-spinner.gif') }}"
                                style="display: none;"> --}}
                        </div>
                        <div class="col-sm-4 col-xs-4">
                            <div class="progress" id="js-progress">
                                <div class="progress-bar collect-reviews-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100">
                                    <span class="progress-val">80%</span>
                                </div>
                            </div>
                            <h5 class="progress-text collect-reviews">Getting all your reviews</h5>
                            {{-- <img class="process-loader"
                                src="{{ asset('public/images/blue-spinner.gif') }}"
                                style="display: none;"> --}}
                        </div>


                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
