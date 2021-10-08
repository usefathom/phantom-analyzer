![share](https://user-images.githubusercontent.com/537943/136579705-7457d0ec-4b9e-44d5-a980-a227a8de223a.png)

# Phantom Analyzer
Phantom Analyzer was a tool we [launched](https://www.producthunt.com/posts/phantom-analyzer) during Halloween 2020. It's a much simpler version of [Blacklight by The Markup](https://themarkup.org/blacklight) and we had so much fun running it for a year. We've decided to retire it, and open-source the code to let people either host it themselves, or simply learn how to run Browsershot on Laravel Vapor.

## Requirements
The following requirements are how we ran Phantom Analyzer.

* PHP 7.4
* [Laravel Vapor](https://vapor.laravel.com/)
* AWS account

You absolutely can run it outside of Vapor, but we haven't tested that, so it's on you :)

# Instructions

1. Create a new project in Laravel Vapor


## FAQ
**Question:** What is Laravel Vapor?

**Answer:** If you've never used Laravel Vapor before, but you're curious, take the [Serverless Laravel](https://serverlesslaravelcourse.com/) course and master Laravel Vapor.

##

**Question:** Who built Phantom Analyzer?

**Answer:** We did. [Fathom Analytics](http://usefathom.com/) is a privacy-first analytics solution founded by [Jack Ellis](https://twitter.com/jackellis) and Paul Jarvis.

##

**Question:** Why are spy pixels bad?

**Answer:** Fathom cofounder, Paul Jarvis, has written more [here](https://usefathom.com/blog/spy).

## Disclaimer
* We offer no kind of liability on this software, or any guarantees. This software is provided as-is.
* We've performed an audit on the codebase, and added credit where it's due, but we cannot guarantee that we've caught everything. For example, we may have used code from StackOverflow or GitHub gists to solve a problem. We've added credit where we can find the source but if we haven't credited you, please contact us and we'll get you added.
* We will not be maintaining this, keeping it up to date or anything else. This is for reference purposes only and provided as-is.
