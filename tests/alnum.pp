%skip space [ ]
%token qm \?
%token alnum [a-z]+
%token nls [\n]+

#program:
  expr() ( ::nls:: expr() )*

expr:
  param_def() | cond_def()


#param_def:
  <alnum>

#cond_def:
  <qm> <alnum>