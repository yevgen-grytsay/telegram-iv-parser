%skip space [ ]
%token qm \?
%token em \!
%token colon \:
%token ucond exists|not_exists|domain|domain_not|path|path_not
%token bool_cond true|false

%token  quote_         "        -> string
%token  string:string  [^"]+
%token  string:_quote  "        -> default

%token nls [\n]+
%token alnum [a-z]+
%token xpath_query [^\r\n]+
%token null null

#program:
  expr() ( ::nls:: expr() )*

expr:
  prop_def() | cond_def()

#prop_def:
  <alnum> <em>{0,2} ::colon:: (string() | <xpath_query> | <null>)

#cond_def:
  (<qm> | <em>) cond()

cond:
  u_cond_def() | bool_cond_def()

u_cond_def:
  <ucond> ::colon:: <xpath_query>

bool_cond_def:
  <bool_cond>

string:
    ::quote_:: <string> ::_quote::