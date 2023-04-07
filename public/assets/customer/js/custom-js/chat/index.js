$(function() {
    'use-strict';

    var baseUrl = $("#base-url").attr('content');

    $(".sendMessage").on("click", function() {
        var orderId = $(this).attr('data-orderid');
        var message = '';


        if ($(".chat-desktop").length == 1) {
            var message = $(".desktopMessage").val();
            $(".desktopMessage" + orderId).val('');
        } else if ($(".chat-mobile").length == 1) {
            alert(2);
            message = $(".mobileMessage").val();
            $(".mobileMessage-" + orderId).val('');
        }
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/send/message',
            data: {
                orderId: orderId,
                message: message,
            },
            dataType: "html",
            success: function(response) {

            }
        });
    });

    $(document).on('keyup', "#message-output", function(event) {

        if (event.keyCode === 13) {
            var orderId = $(this).attr('data-orderid');
            alert(orderId);
            var message = '';

            if ($(".chat-desktop").length == 1) {
                message = $(".desktopMessage").val();
                $(".desktopMessage-" + orderId).val('');
            } else if ($(".chat-mobile").length == 1) {
                message = $(".mobileMessage-" + orderId).val();
                $(".mobileMessage-" + orderId).val('');
            }
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: baseUrl + '/send/message',
                data: {
                    orderId: orderId,
                    message: message,
                },
                dataType: "html",
                success: function(response) {

                }
            });
        }
    });


    $(".odrdetail").on("click", function() {
        $(".order-bxx-gn").fadeIn("slow");
        $(".wd-sl-left-wrapper").hide();
        $(".order-bxx-gn").show();
    });


    $(".bkorderdetail").on("click", function() {
        $(".wd-sl-left-wrapper").fadeIn("slow");
        $(".wd-sl-left-wrapper").show();
        $(".order-bxx-gn").hide();
    });

    try {
        var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        var recognition = new SpeechRecognition();
    } catch (e) {
        console.error(e);
    }

    // var voiceMessage = '';
    var noteContent = '';


    function speech_Recognition(orderId) {
        noteContent = '';
        console.log(".voice-message" + orderId);
        /*-----------------------------
                Voice Recognition
         ------------------------------*/

        // If false, the recording will stop after a few seconds of silence.
        // When true, the silence period is longer (about 15 seconds),
        // allowing us to keep recording even when the user pauses.
        recognition.continuous = true;

        // This block is called every time the Speech APi captures a line.
        recognition.onresult = function(event) {

            // event is a SpeechRecognitionEvent object.
            // It holds all the lines we have captured so far.
            // We only need the current one.
            var current = event.resultIndex;

            // Get a transcript of what was said.
            var transcript = event.results[current][0].transcript;

            // Add the current transcript to the contents of our Note.
            // There is a weird bug on mobile, where everything is repeated twice.
            // There is no official solution so far so we have to handle an edge case.
            var mobileRepeatBug = (current == 1 && transcript == event.results[0][0].transcript);

            if (!mobileRepeatBug) {
                noteContent += transcript;
                console.log(noteContent);
                $(".voice-message" + orderId).val(noteContent);
                // voiceMessage = noteContent;
                // voiceMessage.val(noteContent);
            }
        };

        recognition.onstart = function() {
            console.log('Voice recognition activated. Try speaking into the microphone.');
        }

        recognition.onspeechend = function() {
            console.log('You were quiet for a while so voice recognition turned itself off.');
        }

        recognition.onerror = function(event) {
            if (event.error == 'no-speech') {
                console.log('No speech was detected. Try again.');
            };
        }

    }


    /*-----------------------------
        App buttons and input
    ------------------------------*/

    $(".start").on('click', function() {
        // voiceMessage.val('');
        var orderId = $(this).attr('data-orderid');
        $("#start" + orderId).addClass('d-none');
        $("#stop" + orderId).removeClass('d-none');
        if ($("#start" + orderId).length) {
            // $(".voice-message" + orderId).html('');
            if (noteContent.length) {
                noteContent += ' ';
            }
            speech_Recognition(orderId);
            recognition.start();
            // console.log('Voice recognition start.');
        }
    });

    $(".pause").on('click', function() {
        var orderId = $(this).attr('data-orderid');
        $("#start" + orderId).removeClass('d-none');
        $("#stop" + orderId).addClass('d-none');
        if ($("#stop" + orderId).length) {
            recognition.stop();
            // instructions.text('Voice recognition paused.');
            console.log('Voice recognition paused.');
        }
    });



    // $('#start-record-btn').on('click', function(e) {
    //     if (noteContent.length) {
    //         noteContent += ' ';
    //     }
    //     recognition.start();
    // });


    // $('#pause-record-btn').on('click', function(e) {
    //     recognition.stop();
    //     // instructions.text('Voice recognition paused.');
    //     console.log('Voice recognition paused.');
    // });

    // Sync the text inside the text area with the noteContent variable.
    // noteTextarea.on('input', function() {
    //     noteContent = $(this).val();
    // })

});
