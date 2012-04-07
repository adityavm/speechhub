## Speech Hub, the simple and static blog engine.  
*by [Antonio Ribeiro Alves][al], with modifications and enhancements by [Aditya Mukherjee][avm]*

[al]: https://github.com/alvesjnr
[avm]: https://github.com/adityavm

### What is Speech Hub?

Speech Hub is a simple and static blog engine written in Python. It allows you to create posts (text and link) and publish them on your server. There are two ways of interfacing with Speech Hub: the primary and powerful command-line, and the easier but buggy browser interface.

**Command-Line**: With Speech Hub you are able to create posts, publish them, modify, remove, etc. all using just your \*nix command line (see HOW_TO_USE for the commands). You don't *need* to use a browser to do it. All you need is Speech Hub, a text editor, and a tool to publish the content to your server.

**Browser Interface**: This is written in PHP and provides a sort of wrapper around the command-line interface. You use a browser interface that executes the shell commands required to make Speech Hub work. It's inelegant, but it works. Kind of. Sometimes. It's also based around the [Svbtle][sv] philosophy of simplicity, so it's pretty easy and fun to use when it works. (Has a few niggles with file permissions from time to time.)

[sv]: http://dcurt.is/codename-svbtle

### What do you mean by 'static'?

It is a static tool because all the processing takes place on your computer. From creation of the blog to creating and updating posts; all the leg work is carried out locally. Once you're done, you can push the content to the remote server. There's no dynamic rendering or URL resolution.

### Okay, but what about 'simple'?

If you remember "The Zen of Python, by Tim Peters", the third rule is "Simple is better than complex". We assume here that if you need a static way to create a blog, it may be because Wordpress or Blogspot just became too complex (or complicated) for your purpose. Often, all you need is an easy, quick and simple way to publish your content on the web. So, why should you need to use Wordpress to do it?

*(the above is a modification of the [original README][rm])*

[rm]: https://github.com/alvesjnr/speechhub/blob/master/README.rst
