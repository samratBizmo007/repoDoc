<h1 id="employee_role_lists">Employee Role Lists</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>getEmployeeRoleLists.json</h4>
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
							<h3 id="type29">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>GET</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input29">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
Token : 00ebb320dc888d343dd08e4d8c3fa9881535368159
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output29">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjpbeyJpZCI6MzMsIm5hbWUiOiJEUiJ9LHsiaWQiOjM0LCJuYW1lIjoiUk4ifSx7ImlkIjozNSwibmFtZSI6IlBUIn0seyJpZCI6MzYsIm5hbWUiOiJPVCJ9LHsiaWQiOjM3LCJuYW1lIjoiUEgifSx7ImlkIjozOCwibmFtZSI6IkNNIn0seyJpZCI6MzksIm5hbWUiOiJTVyJ9LHsiaWQiOjQwLCJuYW1lIjoiU1QifSx7ImlkIjo0MSwibmFtZSI6IlJUIn0seyJpZCI6NDIsIm5hbWUiOiJSRCJ9LHsiaWQiOjU2LCJuYW1lIjoiV04ifSx7ImlkIjo1NywibmFtZSI6IkFQUCJ9XX0.TGEOaA6BUYiYUu9oh3JCE_H1yBvw_DfRwF79v8hLEIQ"
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6IkludmFsaWQgaGVhZGVyIHBhc3NlZC4ifQ.Y4Jeb0RFe89kh4-G4rD7HWG_kbAcET5o4uFE8W9-_ZA"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMSwibWVzc2FnZSI6IllvdSBhcmUgdW5hdXRob3JpemVkIHRvIGFjY2VzcyB0aGlzIGxvY2F0aW9uLiJ9.As058aErTIv1Jbqnj4w5MdMzTvshS411w7ZoHc3Te_M"
}

							<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>