# IMSE-WS2018
## How to pull the Java project correctly (IntelliJ)
1. Create a new project from Version Control (Git). URL is https://github.com/utzn42/IMSE-WS2018.git
2. Go to ```File - > Project Structure -> Modules```. Mark ```src``` as your source folder. Confirm, and **don't** add any of the files IntelliJ creates to git.
3. Right Click on the root directory in your IntelliJ Project Structure and create a new directory called ```out```. Go to ```File - > Project Structure -> Project``` and specify the newly created folder as Project compiler output. Then, mark it as excluded in the same fashion as above.
4. Now we need to add the JDBC driver to the project. Download it at https://dev.mysql.com/downloads/connector/j/8.0.html (platform independent zip archive) and unpack the .jar somewhere. Then go to ```File - > Project Structure -> Libraries``` and click +. Select Java and then navigate to the .jar. Again, **don't** add it to Git.
5. Finally, go to the ```KinoJDBC_LoginFrame.java``` class and to the left of the main method, there should be a green triangle. Click on it, and IntelliJ will remember the run configuration.
6. Good to go!

## Use SSL to connect to server via PHP
https://gist.github.com/nguyenanhtu/33aa7ffb6c36fdc110ea8624eeb51e69
