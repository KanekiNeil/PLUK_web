<?php

?>
<div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Important Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- ACCORDION -->
                <div class="accordion" id="infoAccordion">

                    <!-- Accordion Item 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne"
                                    aria-expanded="true">
                                Announcement 1
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                             data-bs-parent="#infoAccordion">
                            <div class="accordion-body">
                                This is the content for announcement 1.
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Item 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo">
                                Announcement 2
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse"
                             data-bs-parent="#infoAccordion">
                            <div class="accordion-body">
                                This is the content for announcement 2.
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Item 3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree">
                                Announcement 3
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse"
                             data-bs-parent="#infoAccordion">
                            <div class="accordion-body">
                                This is the content for announcement 3.
                            </div>
                        </div>
                    </div>

                </div>
                <!-- END ACCORDION -->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>