<h1 id="create_signout_note">Create Signout Note</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>createSignoutNote.json</h4>
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
							<h3 id="type15">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input15">Input</h3>
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
token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXRpZW50X2lkIjoxMDcsImVtcGxveWVlX2lkIjoyNzUsImRlcGFydG1lbnRfaWQiOjEwNywiZGF0ZSI6IjIwMTgtMDgtMjgiLCJ0aW1lIjoiMTI6MDAiLCJzZXJ2aWNlX3RlYW1faWQiOjExLCJkdXJhdGlvbiI6IjAwOjAwOjA1In0.Vs62e_VAq4Nt7AjvTdeQbTLVy49M8W8e_d-qP6Mk9ac
content: (upload recorded file)
   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output15">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlBhdGllbnQgc2luZ291dCBub3RlIGhhcyBiZWVuIHNhdmVkIHN1Y2Nlc3NmdWxseS4iLCJkYXRhIjp7ImlkIjo5NSwiZW1wbG95ZWVfaWQiOjI3NSwiY29udGVudCI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2F1ZGlvXC9zaWdub3V0XC8xNTM1NDM4NzEyNDA2Lm1wNCIsImR1cmF0aW9uIjoiMDA6MDA6MDUiLCJkYXRlIjoiMjgtMDgtMTgiLCJ0aW1lIjoiMTI6MDAgcG0iLCJuYW1lIjoiQWkgQnJha2VyIiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImRlc2lnbmF0aW9uIjoiQ2hhaXIgT2YgVGhlIERlcGFydG1lbnQiLCJkZXBhcnRtZW50IjoiRGVudGlzdHJ5IiwiZW1wbG95ZWVfcm9sZSI6IkRvY3RvciIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiJ9fQ.wnWaTMw5lFKnsMlVPB1Vkx3WK-gvLWDKcE6hx--5GMc

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
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6Ik9vcHMgISBTb21ldGhpbmcgd2VudCB3cm9uZy4ifQ.Wb-KLc0jy7_FDdXCK0NsbXNSxU0kgw7fBgjRRk4jUSE"
}
									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>