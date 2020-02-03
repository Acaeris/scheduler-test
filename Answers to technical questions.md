# Answers to technical questions

1. How long did you spend on the coding test? What would you add to your solution if you had more time?

3 to 4 hours. Uncertain in any more specifics as had to find time to work on this between helping my flatmates move out.
If I had more time, I would have likely finished off the Docker environment so that the command could be run with 
example SQL data.

2. Why did you choose PHP as your main programming language?

When I started learning programming, I was very limited on tools to use as I didn't have a PC at home. This meant I 
could only use the software available on the school PCs: Notepad and QBasic. I started experimenting with using 
Javascript to make dynamic pages but, due to how slow JS was at the time, I realised it didn't quite fit the bill if I
wanted to take this seriously. When I finally got a PC at home, I started learning PHP because it was freely available
on magazine discs. That's the real reason why I chose PHP as my main language. I have expanded to other languages since
then, and there's certainly others I prefer working in but I have over a decade working professionally with PHP at this 
point and I don't think my experience of writing Minecraft plugins in Java really cuts it as a professional avenue ;)

3. What is your favourite thing about your most familiar PHP framework (Laravel / Symfony etc)?

I'm most familiar with Symfony 3. Having migrated projects from Zend Framework to Symfony. The thing I like most about 
it, is the ease of writing PHPSpec tests and developing in a TDD way with it.
 
4. What is your least favourite thing about the above framework?

I'm not a fan of how Symfony handles Commands. It can be quite complicated to write a CLI tool due to the differences in
how Symfony handles validation of arguments vs validation of options. This also severely complicates writing commands in
 a TDD way as it forces you to write a lot more implementation details into the mocks in PHPSpec than I would like.