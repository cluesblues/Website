<div class="magick-header">
<p class="text-center"><a href="#download">Download &amp; Unpack</a> • <a href="#configure">Configure</a>  • <a href="#build">Build</a> • <a href="#install">Install</a> • <a href="#binary">Create a Self-installing Binary Distribution</a> • <a href="#problems">Dealing with Unexpected Problems</a> • <a href="#project">Building Your Custom Project</a></p>

<p  class="lead magick-description">It's possible you don't want to concern yourself with advanced installation under Windows.  If so, you also have the option of installing a self-installing <a href="<?php echo $_SESSION['RelativePath']?>/../script/binary-releases.php#windows">binary release</a> or if you still want to install from source without all the fuss see the simple <a href="<?php echo $_SESSION['RelativePath']?>/../script/install-source.php#windows">Install From Source</a> instructions.  However, if you want to customize the configuration and installation of ImageMagick under Windows, lets begin.</p>

<h2 class="magick-header"><a id="download"></a>Download &amp; Unpack</h2>

<p>Building ImageMagick source for Windows requires a modern version of Microsoft Visual Studio IDE.  Users have reported success with the Borland C++ compiler as well.  If you don't have a compiler you can still install a self-installing <a href="<?php echo $_SESSION['RelativePath']?>/../script/binary-releases.php#windows">binary release</a>.</p>

<p>Download <a href="https://www.imagemagick.org/download/windows/ImageMagick-windows.zip">ImageMagick-windows.zip</a> from <a href="https://www.imagemagick.org/download/windows">ftp.imagemagick.org</a> or its <a href="<?php echo $_SESSION['RelativePath']?>/../script/download.php">mirrors</a> and verify the distribution against its <a href="https://www.imagemagick.org/download/windows/digest.rdf">message digest</a>.</p>

<p>You can unpack the distribution with <a href="http://www.winzip.com">WinZip</a> or type the following from any Command Prompt window:</p>

<pre>
unzip ImageMagick-windows.zip
</pre>

<p>Now that you have the ImageMagick Windows source distribution unpacked, let's configure it.</p>


<h2 class="magick-header"><a id="configure"></a>Configure</h2>

<p>These instructions are specific to building ImageMagick with the <a href="http://msdn.microsoft.com/vstudio/">Visual Studio</a> under Windows XP, Win2K, or Windows 98.  ImageMagick does not include any workspace (DSW) or project files (DSP) except for those included with third party libraries. Instead, there is a <code>configure</code> program that must be built and run which creates the Visual Studio workspaces for ImageMagick.  The Visual Studio system provides four different types of <var>runtime</var> environments that must match across all application, library, and dynamic-library (DLL) code that is built. The <code>configure</code> program creates a set of build files that are consistent for a specific runtime selection listed here:</p>

<ol>
  <li>Dynamic Multi-threaded DLL runtimes (VisualDynamicMT).</li>
  <li>Static Single-threaded runtimes (VisualStaticST).</li>
	<li>Static Multi-threaded runtimes (VisualStaticMT).</li>
	<li>Static Multi-threaded DLL runtimes (VisualStaticMTDLL).</li>
</ol>

<p>In addition to these runtimes, the VisualMagick build environment allows you to select whether to include the X11 libraries in the build or not.  X11 DLLs and headers are provided with the VisualMagick build environment.  Most Windows users are probably not interested in using X11, so you might prefer to build without X11 support.  Since the <code>animate</code>, <code>display</code>, and <code>import</code> program depends on the X11 delegate libraries, these programs will no work if you choose not to include X11 support.</p>

<p>This leads to five different possible build options. The default binary distribution is built using the Dynamic Multi-threaded DLL (VisualDynamicMT) option with the X11 libraries included.  This results in an X11 compatible build using all DLL's for everything and multi-threaded support (the only option for DLL's).</p>

<p>To create a workspace for your requirements, simply go to the <code>VisualMagick\configure</code> folder and open the <code>configure.dsw</code> workspace (for Visual Studio 6) or <code>configure.sln</code> (for Visual Studio 7 or 8). Set the build configuration to <var>Release</var>.</p>

<p>Build and execute the configure program and follow the on-screen instructions.  You should not change any of the defaults unless you have a specific reason to do so.</p>

<p>The configure program has a button entitled:</p>

<p>
  Edit "magick_config.h"
</p>

<p>Click on this button to bring up <code>magick-config.h</code> in Windows Notepad.  Review and optionally change any preprocessor defines in ImageMagick's <code>magick_config.h</code> file to suit your needs.  This file is copied to <code>magick\magick_config.h</code>.  You may safely open <code>magick\magick_config.h</code>, modify it, and recompile without re-running the configure program. In fact, using Notepad to edit the copied file may be preferable since it preserves the original <code>magick_config.h</code> file.</p>

<p>Key user defines in <code>magick_config.h</code> include:</p>

<div class="table-responsive">
<table class="table table-condensed table-striped">
  <tr>
    <td>MAGICKCORE_QUANTUM_DEPTH (default 16)</td>
    <td>Specify the depth of the pixel component depth (8, 16, or 32).  A value of 8 uses half the memory than 16 and may run 30% faster, but provides 256 times less color resolution than a value of 16.  We recommend a quantum depth of 16 because 16-bit images are becoming more prevalent on the Internet.</td>
  </tr>
  <tr>
    <td>MAGICKCORE_INSTALLED_SUPPORT (default undefined)</td>
    <td>Define to build a ImageMagick which uses registry settings or embedded paths to locate installed components (coder modules and configuration files). The default is to look for all files in the same directory as the executable.  You will wand to define this value if you intend on <a href="#install">installing</a> ImageMagick on your system.</td>
  </tr>
  <tr>
    <td>ProvideDllMain (default defined)</td>
    <td>Define to include a DllMain() function ensures that the ImageMagick DLL is properly initialized without participation from dependent applications. This avoids the requirement to invoke InitializeMagick() from dependent applications is only useful for DLL builds.</td>
  </tr>
</table></div>

<p>ImageMagick is now configured and ready to build.</p>

<p>The default build is WIN32.  For 64-bit, open a newly created solution and enter Configuration Manager. Add a x64 configuration, copying the configuration from Win32. Be sure  that it adds the configuration to all the projects.  Now compile.  For the 64-bit build, you will also need to disable X11 support.  Edit magick-config.h and undefine the MAGICKCORE_X11_DELEGATE define.</p>

<h2 class="magick-header"><a id="Build"></a>Build</h2>

<p>After creating your build environment, proceed to open the DSW (or SLN) workspace in the <code>VisualMagick</code> folder.  In the DSW file choose the <var>All</var> project to make it the <var>active</var> project.  Set the build configuration to the desired one (Debug, or Release) and <var>clean</var> and <var>build:</var></p>

<ol>
  <li>Right click on the All project and select <var>Set As Active Project</var></li>
  <li>Select "Build=>Clean Solution"</li>
	<li>Select "Build=>Build Solution"</li>
</ol>

<p>The <var>clean</var> step is necessary in order to make sure that all of the target support libraries are updated with any patches needed to get them to compile properly under Visual Studio.</p>

<p>After a successful build, all of the required files that are needed to run any of the <a href="<?php echo $_SESSION['RelativePath']?>/../script/command-line-tools.php">command line tools</a> are located in the <code>VisualMagick\bin</code> folder.  This includes EXE, DLL libraries, and ImageMagick configuration files.  You should be able to test the build directly from this directory without having to move anything to any of the global SYSTEM or SYSTEM32 areas in the operating system installation.</p>

<p>The Visual Studio distribution of ImageMagick comes with the Magick++ C++ wrapper by default. This add-on layer has a large number of demo and test files that can be found in <code>ImageMagick\Magick++\demo</code>, and <code>ImageMagick\Magick++\tests</code>. There are also a variety of tests that use the straight C API as well in ImageMagick\tests.</p>

<p> All of these programs are <var>not</var> configured to be built in the default workspace created by the configure program. You can cause all of these demos and test programs to be built by checking the box in configure that says:</p>

<p>
  Include all demo and test programs
</p>

<p>In addition, there is another related checkbox (checked by default) that causes all generated project files to be created standalone so that they can be copied to other areas of you system.</p>

<p>This the checkbox:</p>

<p>
  Generate all utility projects with full paths rather then relative paths.
</p>

<p>Visual Studio uses a concept of <var>dependencies</var> that tell it what other components need to be build when a particular project is being build. This mechanism is also used to ensure that components link properly. In my normal development environment, I want to be able to make changes and debug the system as a whole, so I like and NEED to use dependencies. However, most end users don't want to work this way.</p>

<p>Instead they really just want to build the package and then get down to business working on their application. The solution is to make all the utility projects (UTIL_xxxx_yy_exe.dsp) use full absolute paths to all the things they need. This way the projects stand on their own and can actually be copied and used as templates to get a particular custom application compiling with little effort.</p>

<p>With this feature enabled, you should be able to nab a copy of</p>

<pre>
VisualMagick\utilities\UTIL_convert_xxx_exe.dsp  (for C) or
VisualMagick\Magick++\demo\UTIL_demo_xxx_exe.dsp (for C++)
</pre>

<p>and pop it into Notepad, modify it (carefully) to your needs and be on your way to happy compiling and linking.</p>

<p> You can feel free to pick any of the standard utilities, tests, or demo programs as the basis for a new program by copying the project and the source and hacking away.</p>

<p>The choice of what to use as a starting point is very easy.</p>

<p>For straight C API command line applications use something from:</p>

<pre>
ImageMagick\tests or
ImageMagick\utilities (source code) or
ImageMagick\VisualMagick\tests or
ImageMagick\Visualmagick\utilities (project - DSP)
</pre>

<p>For C++ and Magick++ command line applications use something from:</p>

<pre>
ImageMagick\Magick++\tests or ImageMagick\Magick++\demo (source code) or
ImageMagick\VisualMagick\Magick++\tests or  <br/>
ImageMagick\VisualMagick\Magick++\demo (project - DSP)
</pre>

<p>For C++ and Magick++ and MFC windows applications use:</p>

<pre>
ImageMagick\contrib\win32\MFC\NtMagick (source code) or
ImageMagick\VisualMagick\contrib\win32\MFC\NtMagick (project - DSP)
</pre>

<p>The ImageMagick distribution is very modular. The default configuration is there to get you rolling, but you need to make some serious choices when you wish to change things around.</p>

<p>The default options are all targeted at having all the components in one place (e.g. the <code>bin</code> directory of the VisualMagick build tree). These components may be copied to another folder (such as to another computer).</p>

<p>The folder containing the executables and DLLs should contain the following files:</p>

<ol>
  <li>magic.xml</li>
  <li>delegates.xml</li>
  <li>modules.xml</li>
  <li>colors.xml</li>
</ol>

<p>among others.</p>

<p>The <code>bin</code> folder should contains all EXE's and DLL's as well as the very important <code>modules.xml</code> file.</p>

<p>With this default setup, you can use any of the command line tools and run scripts as normal. You can actually get by quite nicely this way by doing something like <code>pushd e:\xxx\yyy\bin</code> in any scripts you write to execute <var>out of</var> this directory.</p>

<p>By default the core of ImageMagick on Win32 always looks in the place were the exe program is run from in order to find all of the files as well as the DLL's it needs.</p>

	<h3>ENVIRONMENT VARIABLES</h3>

		<p>You can use the <var>System</var> control panel to allow you to add and delete what is in any of the environment variables. You can even have user specific environment variables if you wish.</p>

		<h4>PATH</h4>
		  <p>This environmental variable sets the default list of places were Windows looks for EXE's and DLL's. Windows CMD shell seems to look in the <var>current</var> directory first no matter what, which may make it unnecessary to update the PATH. If you wish to run any of utilities from another location then you must add the path to your <code>bin</code> directory in. For instance, to do this for the default build environment like I do, you might add:</p>


<pre>
C:\ImageMagick\VisualMagick\bin
</pre>

		<h4>MAGICK_HOME</h4>
		  <p>If all you do is modify the PATH variable, the first problem you will run into is that ImageMagick may not be able to find any of its <var>modules</var>. Modules are all the IM_MOD*.DLL files you see in the distribution. There is one of these for each and every file format that ImageMagick supports. This environment variable tells the system were to look for these DLL's. The compiled in <var>default</var> is <var>execution path</var> - which says - look in the same place that the application is running <var>in</var>. If you are running from somewhere other then <code>bin</code> - this will no longer work and you must use this variable. If you elect to leave the modules in the same place as the EXE's (a good idea) then you can simply set this to the same place as you did the PATH variable. In my case:</p>

<pre>
C:\ImageMagick\coders
</pre>

			<p>This also the place were ImageMagick expects to find the <code>colors.xml</code>, <code>delegates.xml</code>, <code>magic.xml</code>, <code>modules.xml</code>, and <code>type.xml</code> files.</p>

<p>One cool thing about the modules build of ImageMagick is that you can now leave out file formats and lighten you load. If all you ever need is GIF and JPEG, then simply drop all the other DLL's into the local trash can and get on with your life.</p>

<p>Always keep the XC format, since ImageMagick uses it internally.</p>

<p>You can elect to changes these things the good old <var>hard-coded</var> way. This define is applicable in <code>magick-config.h</code>:</p>

<pre>
#define MagickConfigurePath  "C:\\ImageMagick\\"
</pre>

<p>To view any image in a Microsoft window, type</p>

<pre>
magick image.ext win:
</pre>

<p>Make sure <a href="http://www.cs.wisc.edu/~ghost/">Ghostscript</a> is installed, otherwise, you will be unable to convert or view a Postscript document, and Postscript standard fonts will not be available.</p>

<p>You may use any standard web browser (e.g. Internet Explorer) to browse the ImageMagick documentation.</p>

<p>The Win2K executables will work under Windows 98.</p>

<p>ImageMagick is now configured and built. You can optionally install it on your system as discussed below.</p>

<p>If you are looking to install the ImageMagick COM+ object, see <a href="<?php echo $_SESSION['RelativePath']?>/../script/ImageMagickObject.php">Installing the ImageMagickObject COM+ Component</a>.</p>

<h2 class="magick-header"><a id="Install"></a>Install</h2>

<p>You can run ImageMagick command line utilities directly from the <code>VisualMagick\bin</code> folder, however, in most cases you may want the convenience of an installer script.  ImageMagick provides <a href="http://www.jrsoftware.org">Inno Setup</a> scripts for this purpose.  Note, you must define MAGICKCORE_INSTALLED_SUPPORT at <a href="#configure">configure</a> time to utilize the installer scripts.</p>

<p>To get started building a self-installing ImageMagick executable, go to <code>VisualMagick\installer</code> folder and click on a script that matches your build environment.  Press F9 to build and install ImageMagick.  The default location is <code>C:Program Files\ImageMagick-6.?.?\Q?</code>.  The exact folder name depends on the ImageMagick version and quantum depth.  Once installed, ImageMagick command line utilities and libraries are available to the MS Command Prompt, web scripts, or to meet your development needs.</p>


<h2 class="magick-header"><a id="binary"></a>Create a Self-Installing Binary Distribution</h2>

<h3>Prerequisites</h3>

	<ol>
	<li>Download and install <a href="http://www.jrsoftware.org/isdl.php">Inno Setup 5</a>.</li>
	<li>Download and install <a href="http://strawberryperl.com/">Strawberry Perl</a>.</li>
	</ol>

<h3>Run the Configure Wizard</h3>

	<ol>
	<li>Double-click on <code>VisualMagick/configure/configure.sln</code> to build the configure wizard.</li>
	<li>Select <code>Rebuild All</code> and launch the configure wizard.</li>
	<li>Uncheck <code>Use X11 Stubs</code> and check <code>Build demo and test programs</code>.</li>
	<li>Click on <code>Edit magick_config.h</code> and define <code>MAGICKCORE_INSTALLED_SUPPORT</code>.</li>
	<li>Complete the configure wizard screens to create the ImageMagick Visual C++ workspace.</li>
	</ol>

<h3>Build ImageMagick</h3>

	<ol>
	<li>Double-click on <code>VisualMagick/VisualDynamicMT.sln</code> to launch the ImageMagick Visual workspace.</li>
	<li>Set the active configuration to <code>Win32 Release</code>.</li>
	<li>Select <code>Rebuild All</code> to build the ImageMagick binary distribution.</li>
	</ol>

<h3>Build ImageMagickObject</h3>

	<ol>
	<li>Launch the Command Prompt application and move to the <code>contrib\win32\ATL7\ImageMagickObject</code> folder.</li>
	<li>Build ImageMagickObject with these commands:
<pre>
BuildImageMagickObject clean
BuildImageMagickObject release
</pre></li>
	</ol>

<h3>Build PerlMagick</h3>

	<ol>
	<li>Launch the Command Prompt application and move to the <code>PerlMagick</code> folder.</li>
	<li>Build PerlMagick with these commands:
<pre>
perl Makefile.PL
dmake release
</pre></li>
	</ol>

<h3>Create the Self-installing ImageMagick Binary Distribution</h3>

	<ol>
	<li>Double-click on <code>VisualMagick/installer/im-dll-16.iss</code> to launch the Inno Setup 5 wizard.</li>
	<li>Select <code>File->Compile</code>.</li>
	</ol>

<h3>Install the Binary Distribution</h3>

	<ol>
	<li>Double-click on
	<code><?php echo "VisualMagick/bin/ImageMagick-" . MagickLibVersionText . MagickLibSubversion . "-Q16-windows-dll.exe"; ?></code>
	to launch the ImageMagick binary distribution.</li>
	<li>Complete the installer screens to install ImageMagick on your system.</li>
	</ol>

<h3>Test the Binary Distribution</h3>

	<ol>
	<li>Launch the Command Prompt application and move to the <code>PerlMagick</code> folder and type
<pre>
nmake test
</pre></li>

	<li>Move to the <code>VisualMagick/tests</code> folder and type
<pre>
validate
</pre></li>
	<li>Move to the <code>VisualMagick/Magick++/tests</code> folder and type
<pre>
run_tests.bat
</pre></li>
	<li>Move to the <code>VisualMagick/Magick++/demo</code> folder and type
<pre>
run_demos.bat
</pre></li>
	</ol>

<p>If all the tests pass without complaint, the ImageMagick self-install binary distribution is ready for use.</p>

<h2 class="magick-header"><a id="problems"></a>Dealing with Unexpected Problems</h2>

<p>Chances are the download, configure, build, and install of ImageMagick went flawlessly as it is intended, however, certain systems and environments may cause one or more steps to fail.  We discuss a few problems we've run across and how to take corrective action to ensure you have a working release of ImageMagick.</p>

<p>If the compiler generates an error or if it quits unexpectedly, go to the <a href="http://msdn.microsoft.com/vstudio/">Visual Studio</a> web site and look for Visual Studio service packs.  Chances are, after you download and install all the Visual Studio service packs, ImageMagick will compile and build as expected.</p>


<h2 class="magick-header"><a id="project"></a>Building Your Custom Project</h2>

<p>The Windows <a href="<?php echo $_SESSION['RelativePath']?>/../script/binary-releases.php#windows">binary</a> distribution includes a number of demo projects that you can use as a template for your own custom project.  For example, start with the Button project, generally located in the <code>c:/Program Files/ImageMagick-6.5.5-0/Magick++_demos</code> folder.  If not, be sure to select <code>Configuration Properties->C/C++->Preprocessor</code> and set these definitions:</p>

<pre>
NDEBUG
WIN32
_CONSOLE
_VISUALC_
NeedFunctionPrototypes
_DLL
_MAGICKMOD_
</pre>

</div>
