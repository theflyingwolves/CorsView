var moduleData = [
{
	moduleCode:"CS2102",
	moduleTitle:"Database System",
	moduleDescription:"The aim of this module is to introduce the fundamental concepts and techniques necessary for the understanding and practice of design and implementation of database applications and of the management of data with relational database management systems. The module covers practical and theoretical aspects of design with entity-relationship model, theory of functional dependencies and normalisation by decomposition in second, third and Boyce-Codd normal forms. The module covers practical and theoretical aspects of programming with SQL data definition and manipulation sublanguages, relational tuple calculus, relational domain calculus and relational algebra.",
	modulePrerequisite:"(CS1020 or its equivalent) and (CS1231 or MA1100)",
	modulePreclusion:"CS2102S, IT2002",
	moduleCredit:"4MC"
},
{
	moduleCode:"CS2020",
	moduleTitle:"Data Structures and Algorithms Accelerated",
	moduleDescription:"This module is an accelerated version that combines CS1020 and CS2010. It continues the introduction in CS1010, and emphasises object-oriented programming with application to data structures. Topics covered include object-oriented problem modeling with concepts of objects, classes and methods, object-oriented problem formulation and problem solving, data structure design principles and implementation strageties, abstraction and encapsulation of data structures, object-oriented programming constructs, use of APIs and class libraries, exception handling, lists, linked lists, stacks, queues, hash tables, trees, graphs, and their algorithmic design, various forms of sorting and searching methods, recursive algorithms, and algorithm analysis.",
	modulePrerequisite:"Obtain a grade of at least A- in either CS1010 or CS1101S or CS1010S or CS1010FC or their equivalents",
	modulePreclusion:"CG1102, CG1103, CS1020, CS1020E, CS2010, CS1102, CS1102C, CS1102S",
	moduleCredit:"6MC"
},
{
	moduleCode:"MA1100",
	moduleTitle:"Fundamental Concepts of Mathematics",
	moduleDescription:"This module introduces the language, notions, and methods upon which a sound education in mathematics at the university level is built. Students are exposed to the language of mathematical logic, the idea of rigorous mathematical proofs and fundamental mathematical concepts such as sets, relations and functions. Major topics: Elementary logic, mathematical statements, set operations, relations and functions, equivalence relations, elementary number theory.",
	modulePrerequisite:"'A' level or H2 Mathematics or equiv or [GM1101 and GM1102] or MA1301 or MA1301FC",
	modulePreclusion:"MA1100S, GM1308, CS1231, CS1231S, CS1301, EEE students, CEG students, CPE students, MPE students, COM students, CEC students, FASS students from 2003-2006 cohort who major in Mathematics (for breadth requirement).",
	moduleCredit:"4MC"
},
{
	moduleCode:"MA3238",
	moduleTitle:"Stochastic Process I",
	moduleDescription:"This module introduces the concept of modelling dependence and focuses on discrete-time Markov chains. Topics include discrete-time Markov chains, examples of discrete-time Markov chains, classification of states, irreducibility, periodicity, first passage times, recurrence and transience, convergence theorems and stationary distributions. This module is targeted at students who are interested in Statistics and are able to meet the pre-requisites.",
	modulePrerequisite:"(MA1101 or MA1101R or MA1311 or MA1508) and (ST2131 or MA2216)",
	modulePreclusion:"MA3238. All ISE students.",
	moduleCredit:"4MC"
}
];

var ModuleDatabase = Backbone.Collection.extend({
});

var moduledb = new ModuleDatabase();
moduledb.reset(moduleData);