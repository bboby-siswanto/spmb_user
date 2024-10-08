<div class="row fixed-top" style="margin-top: 70px;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <audio controls class="form-control">
                    <source src="<?=base_url()?>assets/toefl_exam/cc6ed831b3c9be53fdbc37f461e9d197.mp3" type="audio/mpeg">
                </audio> 
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 100px;">
    <div class="col">
        <div class="card">
            <div class="card-body text-justify">
                <h4>
                    Section 1
                    Listening Comprehension
                </h4><hr>
                <p>In this section of the test, you will have an opportunity to demonstrate your ability to understand conversations and talk in English. There are three parts to this section with special directions for each part. Answer all the questions on the basis of what is stated on implied by the speakers in this test. When you take the actual TOEFL test, you will not be allowed to take notes or write in your test book. Try to work on this Sample Test in the same way.</p>
                <h5>PART A</h5>
                <p>
                    <strong>Directions:</strong> In Part A you will hear short conversations between two people. After each conversation, you will hear a question about the conversation. The conversations and questions will not be repeated. After you hear a question, read the four possible answers in your book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.
                </p>
                <p>Listen to an example.</p>
                <p><strong>On the recording, you hear:</strong></p>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>In your book, you read:</strong></p>
                        <ul class="list-unstyled pl-5">
                            <li>A.	He doesn’t like the painting either.</li>
                            <li>B.	He doesn’t know how to paint.</li>
                            <li>C.	He doesn’t have any paintings.</li>
                            <li>D.	He doesn’t know what to do.</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Sample Answer:</strong></p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="customRadio1" name="example1" value="customEx" checked="checked" disabled>
                                    <label class="custom-control-label" for="customRadio1">A.	He doesn’t like the painting either.</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="customRadio2" name="example1" value="customEx" disabled>
                                    <label class="custom-control-label" for="customRadio2">B.	He doesn’t know how to paint.</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="customRadio3" name="example1" value="customEx" disabled>
                                    <label class="custom-control-label" for="customRadio3">C.	He doesn’t have any paintings.</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="customRadio4" name="example1" value="customEx" disabled>
                                    <label class="custom-control-label" for="customRadio4">D.	He doesn’t know what to do.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
<?php
if (count($section_1) > 0) {
foreach ($section_1 as $sec_1) {
?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <p><strong><?=$sec_1->exam_question_number;?>. <?=$sec_1->exam_question_description;?></strong></p>
                <div class="row">
            <?php
            if (count($sec_1->option) > 0) {
                $a_option = $sec_1->option;
                foreach ($a_option as $opt) {
            ?>
                    <div class="col-md-6">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="<?=$opt['question_option_id'];?>" name="<?=$sec_1->exam_question_id;?>" value="<?=$opt['question_option_id'];?>">
                            <label class="custom-control-label" for="<?=$opt['question_option_id'];?>"><?=$opt['exam_question_option_number'];?>. <?=$opt['question_option_description'];?></label>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
}
?>
</div>
<div class="row footer_end">
    <div class="col mt-3 mb-3">
        <button type="button" class="btn btn-block btn-primary" id="next_section">Next Section <i class="fas fa-angle-double-right"></i></button>
    </div>
</div>
<script>
    // sessionStorage.clear();
    let sec_question_a_id = JSON.parse('<?= json_encode($question_section_id)?>');
    if (sec_question_a_id.length > 0) {
        $.each(sec_question_a_id, function(i, v) {
            $("input[name='" + v + "']").change(function() {
                var value = $("input[name='" + v + "']:checked").val();
                sessionStorage.setItem(v, value);
            });

            if (sessionStorage.getItem(v) != null) {
                $('input[name="' + v + '"]').filter("[value='" + sessionStorage.getItem(v) + "']").click();
                // console.log(sessionStorage.getItem(v));
            }
        });
    }
</script>