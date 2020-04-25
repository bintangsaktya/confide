/* [QUIZ ENGINE] */
var quiz = {
  draw : function () {
  // quiz.draw() : draw the quiz

    // Fetch the HTML quiz wrapper
    var wrapper = document.getElementById("quiz-wrap");

    // Loop through all the questions
    // Create all the necessary HTML elements
    for (var index in questions) {
      var number = parseInt(index) + 1; // The current question number
      var qwrap = document.createElement("div"); // A div wrapper to hold this question and options
      qwrap.classList.add("question"); // CSS class, for cosmetics

      // The question - <h1> header
      var question = document.createElement("h1");
      question.innerHTML = number + ") " + questions[index]['q'];
      qwrap.appendChild(question);

      // The options - <input> radio buttons and <label>
      for (var oindex in questions[index]['o']) {
        // The <label> tag
        var label = document.createElement("label");
        qwrap.appendChild(label);

        // The <option> tag
        var option = document.createElement("input");
        option.type = "radio";
        option.value = oindex;
        option.required = true;
        option.classList.add("oquiz"); // Will explain this later in function submit below
        
        // Remember that a radio button group must share the same name
        option.name = "quiz-" + number;
        label.appendChild(option);

        // Add the option text
        var otext = document.createTextNode(questions[index]['o'][oindex]);
        label.appendChild(otext);
      }

      // Finally, add this question to the main HTML quiz wrapper
      wrapper.appendChild(qwrap);
    }

    // Attach submit button + event handler to the quiz wrapper
    var submitbutton = document.createElement("input");
    submitbutton.type = "submit";
    wrapper.appendChild(submitbutton);
    wrapper.addEventListener("submit", quiz.submit);
  },

  submit : function (evt) {
  // quiz.submit() : Handle the calculations when the user submits to quiz

    // Stop the form from submitting
    evt.preventDefault();
    evt.stopPropagation();

    // Remember that we added an "oquiz" class to all the options?
    // We can easily get all the selected options this way
    var selected = document.querySelectorAll(".oquiz:checked");

    // Get the score
    var score = 0;
    for (var index in questions) {
      if (selected[index].value == questions[index]['a']) {
        score++;
      }
    }

    
    var total = selected.length;
    var percent = score / total ;

    var html = "<h1>";
    if (percent>=0.7) {
      html += "SELAMAT DULUR!";
      html += "<br><a href='cert-lulus/index.html'> Download Sertifikat</a>";

    } else if (percent>=0.4) {
      html += "TINGKATKAN PENGETAHUANMU, KAMU BISA BAHAGIA !";
      html += "<br><a href='cert-medium/index.html'> Download Sertifikat</a>";
    } else {
      html += "ENGGA APA APA, CUMAN BUTUH BAHAGIA!";
      html += "<br><a href='cert-low/index.html'> Download Sertifikat</a>";
    }

    html += "</h1>";
    html += "<div>Total jawaban benarmu " + score + " dari " + total + " soal.</div>";
    

    
    document.getElementById("quiz-wrap").innerHTML = html;

    
  }
};

/* [INITNYA] */
window.addEventListener("load", quiz.draw);