<h1 id="employee_schedule">Employee Schedule</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>getEmployeeSchedule.json</h4>
							</div>
							<!-- REQUEST RESPONSE FORMAT -->
							<div class="highlight boderleft">
								<h4 class="colorblue">Supported Formats</h4>  
								<code class="colorblue">JSON</code>
								<code class="colorblue">XML</code>
								<br><br>
								<p class="colorred">*Default Response is in JSON</p>
							</div>

							<!-- REQUEST METHOD -->
							<h3 id="type39">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input39">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
Token:00ebb320dc888d343dd08e4d8c3fa9881535368159
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>
						 	<div class="highlight boderleft">
								<pre >
									<code class="html">
token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbXBsb3llZV9pZCI6MjA0LCJkYXRlIjoiMjAxOC0wMSJ9.wZeQ26ExuPIcFhJMw_Gj2l1dWBXycqE6Aef5jaSV5AQ				
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output39">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjpbeyJkYXRlIjoiMTMtMDEtMjAxOCIsInRpbWUiOiI4YS01cCIsInNlcnZpY2UiOiJHb2xkIDEifSx7ImRhdGUiOiIxNC0wMS0yMDE4IiwidGltZSI6IjhhLTVwIiwic2VydmljZSI6IkdvbGQgMSJ9LHsiZGF0ZSI6IjE1LTAxLTIwMTgiLCJ0aW1lIjoiOGEtNXAiLCJzZXJ2aWNlIjoiR29sZCAxIn0seyJkYXRlIjoiMjMtMDEtMjAxOCIsInRpbWUiOiI4YS01cCIsInNlcnZpY2UiOiJHb2xkIDEifSx7ImRhdGUiOiIyNC0wMS0yMDE4IiwidGltZSI6IjhhLTVwIiwic2VydmljZSI6IkdvbGQgMSJ9LHsiZGF0ZSI6IjI1LTAxLTIwMTgiLCJ0aW1lIjoiOGEtNXAiLCJzZXJ2aWNlIjoiR29sZCAxIn0seyJkYXRlIjoiMjYtMDEtMjAxOCIsInRpbWUiOiI4YS01cCIsInNlcnZpY2UiOiJHb2xkIDEifSx7ImRhdGUiOiIyNy0wMS0yMDE4IiwidGltZSI6IjhhLTVwIiwic2VydmljZSI6IkdvbGQgMSJ9LHsiZGF0ZSI6IjI4LTAxLTIwMTgiLCJ0aW1lIjoiOGEtNXAiLCJzZXJ2aWNlIjoiR29sZCAxIn0seyJkYXRlIjoiMjktMDEtMjAxOCIsInRpbWUiOiI4YS01cCIsInNlcnZpY2UiOiJHb2xkIDEifV19.0qT6j9d2oQ4AtVWhUbaJNlbdwlW1m6zyvcZcNYohohI"
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6Imluc3VmZmljaWVudCBwYXJhbWV0ZXJzIn0.HEqSL2ckJ8hlCAbLKIVYmzM2bdKkXKPbVNC3LsA5R7I"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMywibWVzc2FnZSI6ImZvcmJpZGRlbiJ9.AvSXtHClYOacV0aDAJrERaLbWuvNcJZzMJuI_fhFcIA"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6IkludmFsaWQgaGVhZGVyIHBhc3NlZC4ifQ.Y4Jeb0RFe89kh4-G4rD7HWG_kbAcET5o4uFE8W9-_ZA"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMSwibWVzc2FnZSI6IllvdSBhcmUgdW5hdXRob3JpemVkIHRvIGFjY2VzcyB0aGlzIGxvY2F0aW9uLiJ9.As058aErTIv1Jbqnj4w5MdMzTvshS411w7ZoHc3Te_M"
}								<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>