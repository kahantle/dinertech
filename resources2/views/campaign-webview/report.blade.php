<div class="modal fade " id="report-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
        <div class="modal-content">
            <div class="modal-body modal-inner-blog">
                <h6 class="mb-2 campaign-name"></h6>
                <h5 class="subject-blog"></h5>
                <p class="dating-blog campaign-date"></p>
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-md-6 total-blog-inner">
                            <div class="Total-open-blog">
                                <h5>Total Open</h5>
                                <p>{{ $summary->TotalOpened }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 total-blog-inner">
                            <div class="Total-open-blog">
                                <h5>Total Click</h5>
                                <p>{{ $summary->Clicks }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-blog">
                    <button type="button" class="btn btn-first btn-innint" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
