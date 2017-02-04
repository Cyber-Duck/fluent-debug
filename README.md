#Fluent / Chaining xDebug Library

##Why?

Frameworks like Laravel make heavy usage of, and encourage, method chaining

Consider code like the following random line taken from Laravel framework: 

```
Finder::create()
->files()
->name('*.php')
->in($configPath) 

```

That looks lovely. But there's a problem. Suppose I'm interested in the return value of

```
Finder::create()
->files()
->name('*.php')
```

And wish to examine this in a debugger

At present, the only way I'm aware of doing this in PHP<sup>[1](#myfootnote1)</sup>
 with xDebug is to tediously rewrite the code to 
 introduce intermediate variables, i.e. rewrite the above to
 ```
 $a = Finder::create()
 ->files()
 ->name('*.php')
 
 //put breakpoint on this line:
 $a->in($configPath) 
 
 ```

which doesn't sound particularly difficult in this example but soon becomes a massive mess.

Let's consider another random line:

```
Chicken::load(meatProcess($sausage->bacon()));
```

Suppose I'm interested in the return value of `$sausage->bacon()` here. Where do I stick a breakpoint to get that?
If I put it on the line, I have to step through the call to `bacon` and intercept the return value, which is sometimes rather difficult. 
Or perhaps I can put the breakpoint on the first line of the call to `meatProcess`. A third option is to do something
like 


```
Chicken::load(meatProcess(($a = $sausage->bacon())->ketchup()));
$a;
```

And put a breakpoint on the second line. But suppose the call to `ketchup` has altered `$a`? You're going to be misled!

And in any case, I'm messing up the code again.

This kind of thing is why some programmers are against method chaining in general - the debugging really is made much harder.

See for example https://ocramius.github.io/blog/fluent-interfaces-are-evil/

But we live in the real world and it's a popular way of doing things, and done well as with Laravel it makes your code
so much simpler to read.

##How?

So here I present a very simple extension that I believe takes out the vast majority of the debugging pain caused by fluent
method chaining.

The extension is in two parts. Firstly, there is a trait with two methods. `debugBreak` and `debugBreakIf`. These are 
essentially wrappers around the `xdebug_break` function installed with xdebug. 

Usage is like:

```
Finder::create()
->files()
->name('*.php')
->debugBreak()
->in($configPath) 

```

or perhaps:

```
Finder::create()
->files()
->name('*.php')
->debugBreakIf(2 === $a)
->in($configPath) 

```

or indeed:


```
Finder::create()
->files()
->name('*.php')
->debugBreakIf(function(){return app()->isRunningUnitTests();))
->in($configPath) 

```

To use this, add `use CyberDuck\Traits\DebugsFluently` to any class where you wish to use it (or possibly its parent).
On my ever increasing todo list is a plan to write something that will add this to every class for you automatically.
 
Secondly - primarily intended for usage in function chaining - are the global functions `debugBreak` and `debugBreakIf`.

The above example would become 
```
Chicken::load(meatProcess(debugBreak($sausage->bacon())->ketchup()));
```

Or there is `debugBreakIf` - The second argument works in the same way as the `debugBreakIf` method in the trait.

###Footnotes

<a name="myfootnote1">1</a>: There is a way in .NET - see https://davefancher.com/2016/01/28/functional-c-debugging-method-chains/
