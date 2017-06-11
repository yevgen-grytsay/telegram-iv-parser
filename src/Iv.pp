%skip space [ ]
%token qm \?
%token em \!
%token colon \:
%token ucond exists|not_exists|domain|domain_not|path|path_not
%token bool_cond true|false
%token nls [\n]+
%token alnum [a-z]+
%token xpath_expr [^\r\n]+


#program:
  expr() ( ::nls:: expr() )*

expr:
  param_def() | cond_def()

#param_def:
  <alnum> <em>{0,2}

#cond_def:
  (<qm> | <em>) cond()

cond:
  u_cond_def() | bool_cond_def()

u_cond_def:
  <ucond> ::colon:: <xpath_expr>

bool_cond_def:
  <bool_cond>