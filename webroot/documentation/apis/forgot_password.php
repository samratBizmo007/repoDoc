<h1 id="forgot_password">Forgot Password</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>forgotPassword.json</h4>
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
							<h3 id="type27">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input27">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
{
    token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFpLmJyYWtlckBkYWlseWRvYy5jb20ifQ.8X_6DrBrsFN_V2eLYye14vXoX-0mZLhZvNp65Dy9NmM
}
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
									<p class="colorred">* No header is required.</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output27">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IkVtYWlsIGhhcyBiZWVuIHNlbnQgdG8geW91ciBhY2NvdW50LCBwbGVhc2UgY2hlY2sgeW91ciBlbWFpbC4ifQ.AdD0ATsLwB1GwSysuyfMenHzcbFAEep5o4RNst2JkAI"
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6IlRoZXJlIGlzIG5vIHVzZXIgcmVnaXN0ZXJlZCB3aXRoIHRoaXMgZW1haWwgYWRkcmVzcyJ9.S_IQ1fXzLcqXVrDsUl9Cnj30tEI_XWejWYoTJdkdJq0"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6Imluc3VmZmljaWVudCBwYXJhbWV0ZXJzIn0.HEqSL2ckJ8hlCAbLKIVYmzM2bdKkXKPbVNC3LsA5R7I"
}
{
	"encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6IlRoZXJlIGlzIG5vIHVzZXIgcmVnaXN0ZXJlZCB3aXRoIHRoaXMgZW1haWwgYWRkcmVzcyJ9.S_IQ1fXzLcqXVrDsUl9Cnj30tEI_XWejWYoTJdkdJq0"
}
									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>